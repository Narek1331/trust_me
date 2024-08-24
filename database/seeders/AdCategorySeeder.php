<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdCategory;

class AdCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Верхний',
                'slug' => 'top',
                'width' => '728',
                'height' => '90',
            ],
            [
                'name' => 'Нижний',
                'slug' => 'bottom',
                'width' => '468',
                'height' => '60',
            ]
            ];

        foreach($datas as $data)
        {
            AdCategory::create($data);
        }
    }
}
