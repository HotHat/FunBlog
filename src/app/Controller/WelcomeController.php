<?php declare(strict_types=1);


namespace App\Controller;


use App\Facades\Db;
use Laminas\Diactoros\ServerRequest;

class WelcomeController
{
    public function welcome(ServerRequest $request) {
        echo 'welcome';
        var_dump($request->getQueryParams());
        
        $movie = Db::table('movie')->where('id', 1)->first();
        // var_dump($movie);
        echo 111;
    }
    
}