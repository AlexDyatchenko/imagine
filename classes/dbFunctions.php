<?php

namespace imagine;

use systemFunctions;

require_once('./classes/systemFunctions.php');
require_once('./classes/folderMedia.php');

class dbFunctions
{
    public string $folder = '';

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
        $fileContent = file_get_contents('players.json');
        return json_decode($fileContent);
    }

    public function saveListOfPlayers(array $list) : void
    {
        file_put_contents('players.json', json_encode($list));
    }
}
