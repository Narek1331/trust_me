<?php

namespace App\Traits\Widgets;

use Carbon\Carbon;
use Livewire\Attributes\On;

trait DateRangeTrait
{
    public $fromDate;
    public $toDate;

    #[On('updateFromDate')]
    public function updateFromDate(string $from): void
    {
        $this->fromDate = Carbon::parse($from);
    }

    #[On('updateToDate')]
    public function updateToDate(string $to): void
    {
        $this->toDate = Carbon::parse($to);
    }

}
