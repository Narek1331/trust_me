<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\ReviewType;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviewTypes = ReviewType::get();
        $datas = [];

        $positiveReviewType = $this->getReviewTypeBySlug($reviewTypes, 'positive');
        $negativeReviewType = $this->getReviewTypeBySlug($reviewTypes, 'negative');

        if ($positiveReviewType) {
            $datas = array_merge($datas, $this->getPositiveRatings($positiveReviewType->id));
        }

        if ($negativeReviewType) {
            $datas = array_merge($datas, $this->getNegativeRatings($negativeReviewType->id));
        }

        foreach ($datas as $data) {
            Rating::create($data);
        }
    }

    private function getReviewTypeBySlug($reviewTypes, string $slug)
    {
        return $reviewTypes->where('slug', $slug)->first();
    }

    private function getPositiveRatings(int $reviewTypeId): array
    {
        return [
            ['name' => 'Выполняет обязательства', 'review_type_id' => $reviewTypeId],
            ['name' => 'Надежный сайт', 'review_type_id' => $reviewTypeId],
            ['name' => 'Безопасный сайт', 'review_type_id' => $reviewTypeId],
            ['name' => 'Полезный сайт', 'review_type_id' => $reviewTypeId],
            ['name' => 'Качественный контент', 'review_type_id' => $reviewTypeId],
            ['name' => 'Другое', 'review_type_id' => $reviewTypeId],
        ];
    }

    private function getNegativeRatings(int $reviewTypeId): array
    {
        return [
            ['name' => 'Ненадежный сайт', 'review_type_id' => $reviewTypeId],
            ['name' => 'Фишинговый сайт', 'review_type_id' => $reviewTypeId],
            ['name' => 'Вирусы на сайте', 'review_type_id' => $reviewTypeId],
            ['name' => 'Финансовая пирамида', 'review_type_id' => $reviewTypeId],
            ['name' => 'Рассылка спама', 'review_type_id' => $reviewTypeId],
            ['name' => 'Другое', 'review_type_id' => $reviewTypeId],
        ];
    }
}
