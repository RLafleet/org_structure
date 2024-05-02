<?php
declare(strict_types=1);

namespace classes\loader;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class TwigLoader
{
    /**
     * return Environment
    */
    public static function LoadTwigStable()
    {
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
        return new Environment($loader);
    }
}
