<?php

use App\Services\HelperService;

if (!function_exists('logoPath')) {
    function logoPath()
    {
        $helperService = app(HelperService::class);
        return $helperService->logoPath();
    }
}
