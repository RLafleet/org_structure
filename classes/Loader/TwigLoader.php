<?php
declare(strict_types=1);

namespace App\Loader;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigLoader
{
    /**
     * return Environment
    */
    public static function LoadTwigStable(): Environment
    {
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
        return new Environment($loader);
    }
}
