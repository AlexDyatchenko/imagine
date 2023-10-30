<?php
namespace imagine;

require_once './classes/video.php';

class Page
{
    public function __construct(string $path)
    {
        echo 'path = ' . $path . PHP_EOL;
    }
}