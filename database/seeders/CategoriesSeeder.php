<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed 10 categories
        for ($i = 1; $i <= 10; $i++) {
            $category = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert category and get its ID
            $categoryId = DB::table('categories')->insertGetId($category);

            // Insert translation for each supported language
            foreach (['en', 'hr'] as $locale) {
                $translation = [
                    'category_id' => $categoryId,
                    'title' => "Category $i - $locale",
                    'slug' => "category-$i-$locale",
                    'locale' => $locale,
                ];

                // Insert translation
                DB::table('category_translations')->insert($translation);
            }
        }

        // Add more seed data as needed
    }
}
