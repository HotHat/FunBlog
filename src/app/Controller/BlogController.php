<?php declare(strict_types=1);


namespace App\Controller;


use App\Facades\DB;
use App\Facades\Markdown;
use App\Utils\HyperDown;
use Laminas\Diactoros\ServerRequest;
use function App\Utils\app;
use function App\Utils\http_404;
use function App\Utils\pagination;
use function App\Utils\view;

class BlogController
{
    public function index(ServerRequest $request) {
        $req = $request->getQueryParams();


        $blog = DB::table('t_contents')
            ->where('cid', 71)
            ->first();

        var_dump($blog);

        $content = Markdown::makeHtml($blog['text']);

        var_dump($content);


    }

    public function detail(ServerRequest $request) {
        $req = $request->getQueryParams();

        $id = $req['id'];

        $blog = DB::table('movie')
            ->where('cid', $id)
            ->where('type', 'post')
            ->first();

        if (empty($blog)) {
           return http_404();
        }

        $author = DB::table('t_users')
            ->where('uid', $blog['authId'])
            ->first();

        return view('movie/detail.html', [
            'blog' => $blog,
            'author' => $author
        ]);
    }
}
