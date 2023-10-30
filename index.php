<?php

namespace imagine;
require_once './classes/outputProcessor.php';
require_once './classes/page.php';


$outputProcessor = new outputProcessor('index.html');
$outputProcessor->addToBody(PHP_EOL. 'php works!');
$outputProcessor->echo();