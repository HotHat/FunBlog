<?php declare(strict_types=1);


use FunBlog\Application;

require_once dirname(__DIR__) . '/vendor/autoload.php';


$app = new Application();

$app->run();