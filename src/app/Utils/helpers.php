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

function pagination($current, $pageNum, $listLen, $query) {

    // 只有一页面
    if ($pageNum == 1) {
        return '';
    }

    if ($current < 1) {
        $current = 1;
    } elseif ($current > $pageNum) {
        $current = $pageNum;
    }

    if ($pageNum <= $listLen) {
        $page = [1, $pageNum];
    } else {
        $mid = intval(floor($listLen / 2));
        if ($pageNum-$current <= $mid) {
            $right = $pageNum;
            $left  = $right - $listLen+1;
        } else {
            $left =  1;
            if ($current > $mid) {
                $left = $current-$mid;
            }

            $right  = $left + $listLen-1;
        }

        $page = [$left, $right];
    }
    // var_dump($page);
    $html = '<nav aria-label="Page navigation"><ul class="pagination">';
    if ($current != 1) {
        $query['page'] = $current - 1;
        $url = http_build_query($query);
        $html .= '<li class="page-item"><a class="page-link"  aria-label="Previous" href="?' . $url.'"><span aria-hidden="true">&laquo;</span></a>';
    }

    [$start, $end] = $page;

    for ($i = $start; $i <= $end; ++$i) {
        $query['page'] = $i;
        $url = http_build_query($query);
        $html .= '<li class="page-item ' . ($i == $current ? 'active' : '') . ' "><a class="page-link" href="?'. $url .'">' . $i .'</a> </li>';
    }

    if ($current != $pageNum) {
        $query['page'] = $current + 1;
        $url = http_build_query($query);

        $html .= '<li class="page-item"><a class="page-link" aria-label="Next" href="?    ' . $url . '"><span aria-hidden="true">&raquo;</span></a>';
    }

    $html .= '</ul></nav>';

    return $html;
}


function http_404() {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit(0);
}