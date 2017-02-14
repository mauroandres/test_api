<?php

namespace App\Helpers;

class EnvironmentHelper
{
    public static function isDebug() {
        return (Boolean) env('APP_DEBUG');
    }
}