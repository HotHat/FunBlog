<?php declare(strict_types=1);


// echo 'hello, world';
// var_dump($_REQUEST);
// var_dump($_SERVER);

// header('HTTP/1.1 500 SERVER ERROR');

//
// header('Content-Type: application/json');
// if (ob_start())
// ob_start();


// echo <<< EOF
// <html>
//     <head>
//
//     </head>
//     <body>
//         <h1>Hello world</h1>
//
//     </body>
// </html>
// EOF;
/*
echo '---1111---'.PHP_EOL;
var_dump(ob_get_status());

$content = ob_get_contents();


ob_start();

echo '----2222--'. PHP_EOL;
var_dump(ob_get_status());



echo '-----status----'. PHP_EOL;
var_dump(ob_get_status(true));

ob_end_flush();




ob_end_flush();




// echo $content;

echo '--000----'. PHP_EOL;
var_dump(ob_get_status());

echo '-----level----'. PHP_EOL;
echo ob_get_level();
*/


/**
 *  buffer level
echo 'level ' . ob_get_level(), PHP_EOL;
ob_start();
echo 'level ' . ob_get_level(), PHP_EOL;
ob_start();
echo 'level ' . ob_get_level(), PHP_EOL;
ob_start();
echo 'level ' . ob_get_level(), PHP_EOL;

ob_end_clean();
ob_end_clean();
// ob_end_clean();
// ob_end_flush();
// ob_end_flush();
 */

// echo 'global', PHP_EOL;
// var_dump($GLOBALS);

// echo 'request', PHP_EOL;
// var_dump($_REQUEST);
//
// echo 'post', PHP_EOL;
// var_dump($_POST);
//
// echo 'server', PHP_EOL;
// var_dump($_SERVER);
//
//
// echo 'php input', PHP_EOL;
// echo file_get_contents('php://input');