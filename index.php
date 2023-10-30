<?php

namespace imagine;
require_once './classes/outputProcessor.php';
require_once './classes/page.php';
require_once './classes/pages.php';


$outputProcessor = new outputProcessor('index.html');


$pages = new pages();
$pagesFolders = $pages->getListOfFolders
foreach ($pagesFolders as $folder) {
    $page = new page($folder);
    $videoBlock = $page->generate();
    $outputProcessor->addToBody($videoBlock);    
}
$outputProcessor->addToBody(PHP_EOL. 'php works!');
$outputProcessor->echo();

function 