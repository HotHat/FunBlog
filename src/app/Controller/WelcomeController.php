<?php declare(strict_types=1);


namespace App\Controller;


use App\Facades\DB;
use Laminas\Diactoros\ServerRequest;
use function App\Utils\app;
use function App\Utils\view;

class WelcomeController
{
    public function welcome(ServerRequest $request) {
        // echo 'welcome';
        // var_dump($request->getQueryParams());

        // $movie = Db::table('movie')->where('id', 1)->first();
        // var_dump($movie);
        // echo 111;
        // $a = app();
        // var_dump($a);

        // $loader = new \Twig\Loader\FilesystemLoader();
        // $twig = new \Twig\Environment($loader, [
        //     'cache' => '/path/to/compilation_cache',
        // ]);
        //
        // echo $twig->render('index.html', ['name' => 'Fabien']);
        return view('movie/index.html', ['hello' => 'Hello World!']);
    }

}
