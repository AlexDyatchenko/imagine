<?php

namespace imagine;
require_once './classes/outputProcessor.php';
require_once './classes/page.php';
require_once './classes/pages.php';
require_once './classes/pageChoice.php';

$outputProcessor = new outputProcessor('index.html');

$pages = new pages();

$pc = new pageChoice('./pages/');
$outputProcessor->addToBody($pc->generate());

$outputProcessor->addToBody(PHP_EOL. 'php works!');
$outputProcessor->echo();