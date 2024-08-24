<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
class DateFilter extends Widget
{
    protected static ?int $sort = 1;

    public $fromDate;
    public $toDate;

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.date-filter';

    public function fromDateChanged($value)
    {
        $this->dispatch('updateFromDate', from: $value);
    }

    public function toDateChanged($value)
    {
        $this->dispatch('updateToDate', to: $value);
    }

    public function mount()
    {

    }

}
