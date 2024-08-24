<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Search;
use Carbon\Carbon;
use App\Traits\Widgets\DateRangeTrait;

class SearchesChart extends ChartWidget
{
    use DateRangeTrait;
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Поиски';

    protected int | string | array $columnSpan = 2;


    protected function getData(): array
    {
        // Get the search data grouped by text and check name
        $searches = Search::with('check') // Eager load the check relation
            ->selectRaw('text, check_id, COUNT(*) as count')
            ->groupBy('text', 'check_id')
            ->orderBy('count', 'desc');

        // Apply date filters if provided
        if ($this->fromDate) {
            $searches = $searches->whereDate('created_at', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $searches = $searches->whereDate('created_at', '<=', $this->toDate);
        }

        // Fetch the data and convert it into an array
        $searches = $searches->get();

        $texts = [];
        $counts = [];

        foreach ($searches as $search) {
            $label = $search->text . ' - ' . $search->check->name;
            $texts[] = $label;
            $counts[] = $search->count;
        }

        return [
            'labels' => $texts,
            'datasets' => [
                [
                    'label' => 'Поиски',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }



    protected function getOptions(): array
    {
        return [
            'interaction' => [
                'mode' => 'index',
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
