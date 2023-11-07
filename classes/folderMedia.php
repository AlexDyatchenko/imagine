<?php

namespace imagine;

require_once './classes/imageInfo.php';

class folderMedia
{
    public int       $quizID = 0;
    public string    $description = '';    
    public array     $images = []; //as imageInfo objects
}