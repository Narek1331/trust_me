<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\Widgets\DateRangeTrait;

class RegisteredUsersChart extends ChartWidget
{
    use DateRangeTrait;
    protected static ?int $sort = 1;

    protected static ?string $heading = 'Зарегистрированные пользователи';

    protected int | string | array $columnSpan = 2;


    protected function getData(): array
    {
        // Получаем данные по зарегистрированным пользователям за последние 30 дней
        $users = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereHas('role',function($q){
                $q->where('slug','user');
            })
            // ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date');


        if($this->fromDate) {
            $users = $users->whereDate('created_at', '>=', $this->fromDate);
        }

        if($this->toDate) {
            $users = $users->whereDate('created_at', '<=', $this->toDate);
        }

        $users = $users->get()
        ->pluck('count', 'date')
        ->toArray();

        $totalUsers = array_sum($users);

        $dates = [];
        $counts = [];
        foreach ($users as $date => $count) {
            $dates[] = $date;
            $counts[] = $count;
        }

        return [
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => 'Зарегистрированные пользователи',
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
