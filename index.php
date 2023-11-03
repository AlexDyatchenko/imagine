<?php

namespace imagine;
require_once './classes/outputProcessor.php';
require_once './classes/pageVideo.php';
require_once './classes/pages.php';
require_once './classes/pageChoice.php';

$outputProcessor = new outputProcessor('index.html');

$pages = new pages();
// if ($SERVER[''] !== null) {}
$pc = new pageChoice();
$outputProcessor->addToBody($pc->generatePage());

$outputProcessor->addToBody(PHP_EOL. 'php works!');
echo $outputProcessor->echo();