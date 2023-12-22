<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Meal;
use Illuminate\Support\Facades\App;

class MealsController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->input('locale', App::getLocale());

        $perPage = $request->input('per_page', 5); // Set a default or get it from the request
        $currentPage = $request->input('page', 1); // Set a default or get it from the request

        $filterDiffTime = $request->input('diff_time', 0);
        $filterCategory = $request->filled('category') ? "category_translations.title = '" . $request->input('category') . "'" : 1;
        $filterTags = $request->filled('tags') ? "tag_translations.title = '" . $request->input('tags') . "'" : 1;
        $filterIngredients = $request->filled('ingredients') ? "ingredient_translations.title = '" . $request->input('ingredients') . "'" : 1;

        if ($filterDiffTime == 1) {
            $filterCategory = 1;
            $filterTags = 1;
            $filterIngredients = 1;
        }

        // Get meals joined with category and get both of their translations
        $meals = Meal::join('meal_translations', function ($join) use ($locale,$filterCategory,$filterTags,$filterIngredients) {
            $join->on('meals.id', '=', 'meal_translations.meal_id')
                ->where('meal_translations.locale', $locale);
        })
            ->join('categories', 'meals.category_id', '=', 'categories.id')
            ->join('category_translations', function ($join) use ($locale,$filterCategory,$filterTags,$filterIngredients) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', $locale)
                    ->where($filterCategory);
            })
            ->select(
                'meals.*',
                'meal_translations.title as meal_title',
                'meal_translations.description as meal_description',
                'category_translations.title as category_title',
                'category_translations.slug as category_slug'
            )
            ->get();

        // Manual pagination
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedMeals = $meals->slice($startIndex, $perPage);

        $totalItems = $meals->count();
        $totalPages = ceil($totalItems / $perPage);

        $meta = [
            'currentPage' => $currentPage,
            'totalItems' => $totalItems,
            'itemsPerPage' => $perPage,
            'totalPages' => $totalPages,
        ];

        // Create the data array
        $data = $slicedMeals->map(function ($meal) use ($request) {

            $tagIds = json_decode($meal->tags_id);
            $ingredientIds = json_decode($meal->ingredients_id);
            $locale = $request->input('locale', App::getLocale());

            // Get tags and their translations
            $tags = collect();
            foreach ($tagIds as $tagId) {
                $tag = Tag::where('tags.id', $tagId)
                    ->join('tag_translations', function ($join) use ($locale) {
                        $join->on('tags.id', '=', 'tag_translations.tag_id')
                            ->where('tag_translations.locale', $locale);
                    })
                    ->first();

                if ($tag) {
                    $tags->push($tag); // Add the tag to the collection
                }
            }

            // Get ingredients and their translations
            $ingredients = collect();
            foreach ($ingredientIds as $ingredientId) {
                $ingredient = Ingredient::where('ingredients.id', $ingredientId)
                    ->join('ingredient_translations', function ($join) use ($locale) {
                        $join->on('ingredients.id', '=', 'ingredient_translations.ingredient_id')
                            ->where('ingredient_translations.locale', $locale);
                    })
                    ->first();

                if ($ingredient) {
                    $ingredients->push($ingredient);
                }
            }

            // Map each meal to the desired structure
            return [
                'id' => $meal->id,
                'title' => $meal->meal_title,
                'description' => $meal->meal_description,
                'status' => $meal->status,
                'category' => $meal->category ? [
                    'id' => $meal->category->id,
                    'title' => $meal->category_title,
                    'slug' => $meal->category_slug,
                ] : null,
                // Print tags
                'tags' => $tags->map(function ($tag) {
                    return [
                        'id' => $tag->id,
                        'title' => $tag->getAttributes()['title'],
                        'slug' => $tag->getAttributes()['slug'],
                    ];
                })->toArray(),
                // Print ingredients
                'ingredients' => $ingredients->map(function ($ingredient) {
                    return [
                        'id' => $ingredient->id,
                        'title' => $ingredient->getAttributes()['title'],
                        'slug' => $ingredient->getAttributes()['slug'],
                        // Include additional fields as needed
                    ];
                })->toArray(),
            ];
        });

        // Print links
        $links = [
            'prev' => $currentPage > 1 ? $request->fullUrlWithQuery(['page' => $currentPage - 1]) : null,
            'next' => $currentPage < $totalPages ? $request->fullUrlWithQuery(['page' => $currentPage + 1]) : null,
            'self' => $request->fullUrlWithQuery(['page' => $currentPage]),
        ];

        // Return the response as JSON with the desired structure
        return response()->json([
            'meta' => $meta,
            'data' => $data,
            'links' => $links,
        ]);
    }

}
