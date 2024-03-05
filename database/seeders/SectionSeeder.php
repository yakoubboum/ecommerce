<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = ['ar','en'];


        $sections = [
            'Electronics' => [
                'en' => 'Electronics',
                
                'ar' => 'إلكترونيات',
            ],
            'Clothing & Accessories' => [
                'en' => 'Clothing & Accessories',
                
                'ar' => 'ملابس وإكسسوارات',
            ],
            'Home & Kitchen' => [
                'en' => 'Home & Kitchen',
                
                'ar' => 'المنزل والمطبخ',
            ],
            'Beauty & Health' => [
                'en' => 'Beauty & Health',
                
                'ar' => 'الجمال والصحة',
            ],
            'Toys & Games' => [
                'en' => 'Toys & Games',
                'fr' => 'Jouets et Jeux',
                'ar' => 'ألعاب',
            ],
            'Books & Stationery' => [
                'en' => 'Books & Stationery',
                
                'ar' => 'كتب وقرطاسية',
            ],
            'Sports & Outdoors' => [
                'en' => 'Sports & Outdoors',
                
                'ar' => 'الرياضة والهواء الطلق',
            ],
            'Groceries & Beverages' => [
                'en' => 'Groceries & Beverages',
                
                'ar' => 'البقالة والمشروبات',
            ],
            'Pets & Supplies' => [
                'en' => 'Pets & Supplies',
                
                'ar' => 'ال الحيوانات الأليفة والمستلزمات',
            ],
            'Furniture & Decor' => [
                'en' => 'Furniture & Decor',
                
                'ar' => 'الأثاث والديكور',
            ],
            // Add more sections with translations here
        ];

        foreach ($sections as $sectionName => $translations) {
            $sectionId = DB::table('sections')->insertGetId([
                'created_at' => now(),
            ]);

            foreach ($locales as $locale ) {
                if (isset($translations[$locale])) {
                    DB::table('section_translations')->insert([
                        'section_id' => $sectionId,
                        'locale' => $locale,
                        'name' => $translations[$locale],
                    ]);
                }
            }
    }

    }
}