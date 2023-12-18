<?php

namespace imagine;

use constants;
use stdClass;
use systemFunctions;

require_once('./classes/systemFunctions.php');
require_once('./classes/folderMedia.php');
require_once('./classes/player.php');

class dbFunctions
{
    public string $folder = '';
    public string $playersFileName = './Games/Game1/players.json';
    public string $answersFileName = './Games/Game1/answers.json';
    public string $gameFileName    = './Games/Game1/game.json';

    public function __construct() {
        $this->folder = $GLOBALS['mediaFolder'];
    }
    # return associative array: key = quiz ID
    public function getListOfMedia(): array
    {
        $list = [];
        $answers = $this->getAnswers();
        $playerID = constants::getGame()->currentPlayerID;
        $sf = new systemFunctions();
        $pagesFolders = $sf->getListOfFolders($this->folder);
        file_put_contents('./log.txt', 'folders= ' . json_encode($pagesFolders) . PHP_EOL, FILE_APPEND);
        foreach ($pagesFolders as $folder) {
            $mediaObject = $this->getMediaObjectFromFolder($folder);
            $mediaObject->images = $sf->getListOfFiles($folder, '*.webm');
            $mediaObject = $this->setIfQuizesAnswered($mediaObject, $answers, $playerID);
            $list[$mediaObject->quizID] = $mediaObject;
            
            //file_put_contents('./log.txt', 'getMediaObjectFromFolder' .PHP_EOL, FILE_APPEND);
        }
        // logger::log('fun compareBySortOrder= ' . compareBySortOrder($list[2], $list[1]));
        $listToSort = [];
        foreach ($list as $value) {
            $listToSort[$value->sortOrder]=$value;
        }
        ksort($listToSort);
        $list = [];
        foreach ($listToSort as $value) {
            $list[$value->quizID] = $value;
        }
        // usort($list, 'compareBySortOrder');
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
        if (property_exists($objctFromFile, "sortOrder")) {
            $object->sortOrder = $objctFromFile->sortOrder;
        }
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
            logger::log('players raw===');
            $fileContent = file_get_contents($this->playersFileName);
            
            $listRaw = json_decode($fileContent);  
            foreach ($listRaw as $playerJson) {
                $player = new player;
                $player->name = $playerJson->name;
                $player->ID = $playerJson->ID;
                $player->gender = genders::tryFrom($playerJson->gender);
                $list[$player->ID] =$player;
            }  
        }
        // logger::log('players read: '. json_encode($list,JSON_PRETTY_PRINT));
        return $list;
    }

    public function saveListOfPlayers(array $list) : void
    {
        file_put_contents($this->playersFileName, json_encode($list));
    }

    function readGame() : game {
        logger::log('readGame ===');
        $fileContent = file_get_contents($this->gameFileName);
        $objectFromFile = json_decode($fileContent);
        $game = new game;
        try {
            if (property_exists($objectFromFile, 'currentPlayerID')) {
                $game->currentPlayerID = $objectFromFile->currentPlayerID;
                $players=$this->getListOfPlayers();
                $game->currentPlayer = $players[$game->currentPlayerID];
            }
        } catch (\Throwable $th) {
            logger::log('error in getting player');
        }
        return $game;
    }

    function saveGame(): void {
        $gameJson = json_encode(constants::getGame(), JSON_PRETTY_PRINT);
        file_put_contents($this->gameFileName, $gameJson);
        logger::log('Game saved.');
    }

    function getAnswers() : array {
        logger::log('getSelectedAnswers ===');
        if (file_exists($this->answersFileName)) {
            $fileContent = file_get_contents($this->answersFileName);
            $listRaw = json_decode($fileContent);  
        } else {
            $listRaw = [];
        }
        logger::log('getSelectedAnswers ' . json_encode($listRaw));
        return $listRaw;
    }

    function saveChoice(string $pathToVideo): void 
    {
        // logger::log('answer 1');
        $obj = $this->getAnswers();
        $game = constants::getGame();
        $newAnswer = new answer();
        $newAnswer->playerID = $game->currentPlayerID;
        $pathToVideo = str_replace('\/', '/', $pathToVideo);
        $newAnswer->pathToVideo = $pathToVideo;        
        $obj[] = $newAnswer;
        $answersJson = json_encode($obj, JSON_PRETTY_PRINT);
        file_put_contents($this->answersFileName, $answersJson);
        logger::log('answer saved');
    }

    public function setIfQuizesAnswered(
        folderMedia $mediaObject, 
        array $answers, 
        int $playerID) : folderMedia {
        foreach ($mediaObject->images as $image) {
            foreach ($answers as $answer) {
                if ($image === $answer->pathToVideo || $answer->playerID === $playerID) {
                    $mediaObject->alreadyAnswered = true;
                    return $mediaObject;
                }
            }            
        }
        return $mediaObject;
    }
}

function compareBySortOrder($a, $b) {
    return $a->sortOrder - $b->sortOrder;
}