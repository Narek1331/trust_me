<?php

namespace App\Services;
use App\Models\DesignSetting;
use Illuminate\Support\Facades\Schema;

class HelperService
{
    public function logoPath()
    {
        $tableExists = Schema::hasTable('design_settings');

        if($tableExists)
        {
            $designSetting = DesignSetting::first();

            if($designSetting && $designSetting->logo_path)
            {
                return '/storage/' . $designSetting->logo_path;
            }
        }

        return '/images/logos/main.png';
    }
}
