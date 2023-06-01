<?php declare(strict_types=1);


namespace App\Controller;


use App\Facades\DB;
use Laminas\Diactoros\ServerRequest;
use function App\Utils\app;
use function App\Utils\pagination;
use function App\Utils\view;

class MovieController
{
    public function index() {

        return view('movie/index.html', ['nav' => '']);
    }

    public function nav(ServerRequest $request) {

        // var_dump($request->getQueryParams());
        $a = parse_url('http://abf.com?q=1&p=2&a[]=1&a[]=2');
        parse_str($a['query'], $b);
        // var_dump($a);
        // var_dump($b);
        // var_dump(http_build_query($b));




        $list[] =  pagination(0, 10,  5, $b);
        $list[] =  pagination(1, 10,  5, $b);
        $list[] =  pagination(2, 10,  5, $b);
        $list[] =  pagination(3, 10,  5, $b);
        $list[] =  pagination(4, 10,  5, $b);
        $list[] =  pagination(5, 10,  5, $b);
        $list[] =  pagination(6, 10,  5, $b);
        $list[] =  pagination(7, 10,  5, $b);
        $list[] =  pagination(8, 10,  5, $b);
        $list[] =  pagination(9, 10,  5, $b);
        $list[] =  pagination(10, 10,  5, $b);
        $list[] =  pagination(11, 10,  5, $b);


        // $list[] =  pagination(0, 10,  6, $b);
        // $list[] =  pagination(1, 10,6  , $b);
        // $list[] =  pagination(2, 10,6  , $b);
        // $list[] =  pagination(3, 10,6  , $b);
        // $list[] =  pagination(4, 10,6  , $b);
        // $list[] =  pagination(5, 10,6  , $b);
        // $list[] =  pagination(6, 10,6  , $b);
        // $list[] =  pagination(7, 10,6  , $b);
        // $list[] =  pagination(8, 10,6  , $b);
        // $list[] =  pagination(9, 10,6  , $b);
        // $list[] =  pagination(10, 10,  6, $b);
        // $list[] =  pagination(11, 10,  6, $b);

        return view('movie/nav.html', ['nav' => $list]);
    }

}
