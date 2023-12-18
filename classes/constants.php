<?php

use imagine\game;

class constants
{
    public static function getGame() : game {
        return $GLOBALS['game'];
    }

    public static function getMediaFolder() : game {
        return $GLOBALS['mediaFolder'];
    }
}