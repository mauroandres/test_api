<?php

namespace App\Helpers;

class EnvironmentHelper
{
    /**
     * Return is debug mode
     *
     * @return Boolean
     */
    public static function isDebug() 
    {
        return (Boolean) env('APP_DEBUG');
    }

    /**
     * Return application host
     *
     * @return String
     */
    public static function host()
    {
        return (String) env('APP_HOST');
    }
}        