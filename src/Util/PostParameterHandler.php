<?php

namespace App\Util;

class PostParameterHandler
{
    /**
     * @param string $name
     * @param string $defaultValue
     * @return string
     */
    public static function GetParameter(string $name,  string $defaultValue = ""): string
    {
        return $_POST[$name] ?? $defaultValue;
    }
}