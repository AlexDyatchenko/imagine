<?php

namespace imagine;

require_once './classes/imageInfo.php';

class folderMedia
{
    public int       $quizID = 0;
    public string    $description = '';
    public string    $buttonCaption = '';
    public string    $question = '';
    public string    $questionForHim = '';
    public string    $questionForHer = '';
    public array     $images = []; //as imageInfo objects
    public bool      $forHim = false;
    public bool      $forHer = false;
    public string    $group = '';
    public string    $colorButton = '';
    public bool      $alreadyAnswered = false;
    public int       $sortOrder = 100;
}
