<?php declare(strict_types=1);


namespace App\Utils;


use App\Application;

function app() {
    return Application::getInstance();
}

function view($template, $params) {
    $engine = app()->get('template_engine');
    return $engine->render($template, $params);
}

