<?php

namespace imagine;

use router;

require_once './classes/outputProcessor.php';
require_once './classes/systemFunctions.php';
require_once './classes/dbFunctions.php';
require_once './classes/router.php';

$router = new router();
$router->route();

//$url = $_SERVER['QUERY_STRING'];
//file_put_contents('./log.txt', '4' . json_encode($_SERVER).PHP_EOL, FILE_APPEND);
        


// $outputProcessor->addToBody(PHP_EOL. 'php works!');
