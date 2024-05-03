<?php

namespace classes\util;

class PostParameterHandler
{
    /**
     * @return string
     */
    public static function GetParameter(string $name,  string $defaultValue = "")
    {
        return $_POST[$name] ?? $defaultValue;
    }
}