<?php

namespace imagine;

use systemFunctions;

require_once('./classes/systemFunctions.php');
require_once('./classes/folderMedia.php');
require_once('./classes/player.php');

class dbFunctions
{
    public string $folder = '';
    public string $playersFileName = './Games/Game1/players.json';

    public function __construct() {
        $this->folder = $GLOBALS['mediaFolder'];
    }
    # return associative array: key = quiz ID
    public function getListOfMedia(): array
    {
        $list = [];
        $sf = new systemFunctions();
        $pagesFolders = $sf->getListOfFolders($this->folder);
        file_put_contents('./log.txt', 'folders= ' . json_encode($pagesFolders) . PHP_EOL, FILE_APPEND);
        foreach ($pagesFolders as $folder) {
            $mediaObject = $this->getMediaObjectFromFolder($folder);
            $mediaObject->images = $sf->getListOfFiles($folder, '*.webm');
            $list[$mediaObject->quizID] = $mediaObject;
            
            //file_put_contents('./log.txt', 'getMediaObjectFromFolder' .PHP_EOL, FILE_APPEND);
        }
        return $list;
    }

    public function getMediaObjectFromFolder(string $folder): folderMedia
    {
        $object = new folderMedia;
        if (!file_exists($folder . '/description.json')) {
            return $object;
        }
        $fileContent = file_get_contents($folder . '/description.json');
        $objctFromFile = json_decode($fileContent);
        $object->description = $objctFromFile->description;
        $object->quizID      = $objctFromFile->quizID;
        $object->forHim      = $objctFromFile->forHim;
        $object->forHer      = $objctFromFile->forHer;
        $object->colorButton      = $objctFromFile->colorButton;
        $object->group      = $objctFromFile->group;

        return $object;
    }

    public function getListOfPlayers() : array
    {
        $list = [];
        if (file_exists($this->playersFileName) === false) {
            for ($i=1; $i <= 4; $i++) { 
                $newPlayer = new player;
                $list []= $newPlayer;
            }
        } else {
            $fileContent = file_get_contents($this->playersFileName);
            $list = json_decode($fileContent);    
        }
        return $list;
    }

    public function saveListOfPlayers(array $list) : void
    {
        file_put_contents($this->playersFileName, json_encode($list));
    }
}
