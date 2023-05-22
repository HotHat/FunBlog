<?php declare(strict_types=1);


namespace FunBlog\Controller;


use Laminas\Diactoros\ServerRequest;

class WelcomeController
{
    public function welcome(ServerRequest $request) {
        echo 'welcome';
        var_dump($request->getQueryParams());
    }
    
}