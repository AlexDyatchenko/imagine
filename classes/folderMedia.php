<?php

namespace imagine;

require_once './classes/imageInfo.php';

class folderMedia
{
    public string    $description = '';
    public string    $question = '';
    public array     $images = []; //as imageInfo objects
}