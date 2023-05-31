<?php declare(strict_types=1);


namespace App\Utils;


use App\Application;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

function app() {
    return Application::getInstance();
}

function view($template, $params) {
    $engine = app()->get('template_engine');
    return $engine->render($template, $params);
}


// Does not support flag GLOB_BRACE
function glob_recur($dir, $pattern)
{
    $path = realpath($dir);
    $result = [];
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $file)
    {
        $fullPath = $file->getPath() . '/' . $file->getFilename();
        if (preg_match($pattern, $fullPath, $match)) {
            $result[] = $fullPath;
        }
    }

    return $result;
}
