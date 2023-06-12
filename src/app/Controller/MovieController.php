<?php declare(strict_types=1);


namespace App\Controller;


use App\Facades\DB;
use Laminas\Diactoros\ServerRequest;
use function App\Utils\app;
use function App\Utils\http_404;
use function App\Utils\pagination;
use function App\Utils\view;

class MovieController
{
    public function index(ServerRequest $request) {
        $req = $request->getQueryParams();
        $keywords = $req['keywords'] ?? '';

        $page = intval($req['page'] ?? 1);

        $offset = ($page - 1) * 15;

        $cnt = DB::table('movie')->count()->first();

        $count = $cnt['count'];
        // var_dump($count);die(0);

        $query = DB::table('movie')
            ->limit($offset, 15)
            ->orderBy('id', 'DESC');

        if ($keywords) {
            $query->where('name', 'LIKE', '%' . $keywords . '%');
        }

        $data = $query->get();

        $page =  pagination($page, $count,  5, $req);


        return view('movie/index.html', ['list' => $data, 'page' => $page, 'keywords' => $keywords ]);
    }

    public function detail(ServerRequest $request) {
        $req = $request->getQueryParams();

        $id = $req['id'];

        $movie = DB::table('movie')
            ->where('site_id', $id)
            ->first();

        if (empty($movie)) {
           http_404();
        }

        return view('movie/detail.html', ['movie' => $movie]);
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
