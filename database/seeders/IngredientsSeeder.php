<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed 10 ingredients
        for ($i = 1; $i <= 10; $i++) {
            $category = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert ingredient and get its ID
            $categoryId = DB::table('ingredients')->insertGetId($category);

            // Insert translation for each supported language
            foreach (['en', 'hr'] as $locale) {
                $translation = [
                    'ingredient_id' => $categoryId,
                    'title' => "Ingredient $i - $locale",
                    'slug' => "ingredient-$i-$locale",
                    'locale' => $locale,
                ];

                // Insert translation
                DB::table('ingredient_translations')->insert($translation);
            }
        }

        // Add more seed data as needed
    }
}
