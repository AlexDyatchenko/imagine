<?php

namespace imagine;

class logger
{
    public static string $path = './log.txt';

    public static function log(string $text) : void
    {
        file_put_contents('./log.txt', 
        $text .PHP_EOL, 
        FILE_APPEND);
    }
}
