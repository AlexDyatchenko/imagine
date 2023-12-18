<?php

namespace imagine;

use router;

require_once './classes/outputProcessor.php';
require_once './classes/systemFunctions.php';
require_once './classes/dbFunctions.php';
require_once './classes/router.php';
require_once './classes/playersController.php';
require_once './classes/apiResponse.php';
require_once './classes/quizChoicePage.php';
require_once './classes/logger.php';
require_once './classes/constants.php';
require_once './classes/game.php';
require_once './classes/videoQuizPage.php';
require_once './classes/answer.php';

$GLOBALS['mediaFolder'] = './media/';
// $GLOBALS['mediaFolder'] = './mediaTemp/';
// $f = is_dir($GLOBALS['mediaFolder']) ? 'true' : 'false';
// echo 'bool = ' . $f;

file_put_contents('./log.txt', '1===' .PHP_EOL, FILE_APPEND);
$router = new router();
$router->route();

//$url = $_SERVER['QUERY_STRING'];
//file_put_contents('./log.txt', '4' . json_encode($_SERVER).PHP_EOL, FILE_APPEND);
        


// $outputProcessor->addToBody(PHP_EOL. 'php works!');
