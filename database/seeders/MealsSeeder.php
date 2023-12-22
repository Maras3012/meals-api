<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all categories once
        $categories = DB::table('categories')->get();
        $ingredients = DB::table('ingredients')->get();
        $tags = DB::table('tags')->get();

        foreach (range(1, 10) as $i) {
            $status = rand(0, 1) == 0 ? 'created' : 'deleted';
            $ingredientIds = [$ingredients->random()->id, $ingredients->random()->id];
            $tagIds = [$tags->random()->id, $tags->random()->id];

            // Get a random category for each iteration
            $category = $categories->random();

            // Create Meal
            $mealId = DB::table('meals')->insertGetId([
                'status' => $status,
                'category_id' => $category->id,
                'ingredients_id' => json_encode($ingredientIds),
                'tags_id' => json_encode($tagIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert translation for each supported language
            foreach (['en', 'hr'] as $locale) {
                DB::table('meal_translations')->insert([
                    'meal_id' => $mealId,
                    'title' => "Meal $i $locale",
                    'description' => "Description for Meal $i $locale",
                    'locale' => $locale,
                ]);
            }
        }
    }
}
