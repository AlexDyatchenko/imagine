<?php

namespace imagine;
require_once './classes/outputProcessor.php';
require_once './classes/pageVideo.php';
require_once './classes/pages.php';
require_once './classes/pageChoice.php';

$outputProcessor = new outputProcessor('index.html');

$pages = new pages();
// $_SERVER
$url = $_SERVER['QUERY_STRING'];
file_put_contents('./log.txt', '4' . json_encode($_SERVER).PHP_EOL, FILE_APPEND);

parse_url($url, PHP_URL_QUERY);
// if ($SERVER[''] !== null) {}
        
$pc = new pageChoice();
$outputProcessor->setParameter($pc->generatePage());

// $outputProcessor->addToBody(PHP_EOL. 'php works!');
echo $outputProcessor->echo();