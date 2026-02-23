<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keputusanCategories = [
            'Peraturan Dirjen',
            'Keputusan Dirjen',
            'Keputusan KPA',
            'Keputusan KPB',
            'Keputusan PPK',
            'Surat Edaran',
        ];

        $dataDukungCategories = [
            'Rancangan Undang-Undang',
            'Rancangan Peraturan Pemerintah',
            'Rancangan Instruksi Presiden',
            'Rancangan Peraturan Menteri',
            'Rancangan Keputusan Menteri',
            'Rancangan Instuksi Menteri',
            'Rancangan Peraturan Dirjen',
            'Rancangan Keputusan Dirjen',
            'Rancangan Surat Edaran'
        ];

        $pejabat = [
            'Dirjen',
            'KPA',
            'KPB',
            'PPK',
        ];

        foreach($keputusanCategories as $name){
            Category::updateOrCreate(
                 [
                'slug' => Str::slug($name). '-keputusan',
                ],
                [
                    'name' => $name,
                    'type' => 'keputusan',
                ]
            );
        }

        foreach($dataDukungCategories as $name){
            Category::updateOrCreate(
                 [
                'slug' => Str::slug($name). '-data-dukung',
                ],
                [
                    'name' => $name,
                    'type' => 'data-dukung',
                ]
            );
        }

        foreach($pejabat as $name){
            Category::updateOrCreate(
                 [
                'slug' => Str::slug($name). '-data-dukung',
                ],
                [
                    'name' => $name,
                    'type' => 'pejabat',
                ]
            );
        }
    }
}
