<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReviewType;
class ReviewTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Положительный',
                'slug' => 'positive'
            ],
            [
                'name' => 'Нейтральный',
                'slug' => 'neutral'
            ],
            [
                'name' => 'Отрицательный',
                'slug' => 'negative'
            ]
        ];

        foreach($datas as $data)
        {
            ReviewType::create($data);
        }
    }
}
