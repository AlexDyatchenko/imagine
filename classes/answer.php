<?php

namespace imagine;

use DateTime;

class answer
{
    public int $playerID = 0;
    public string $pathToVideo;
    public DateTime $time;

    function __construct()
    {
        $this->time = new \DateTime();
    }
}
