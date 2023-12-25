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
    public string $quizes = './Games/Game1/quizes.json';
    public string $gameFileName    = './Games/Game1/game.json';

    public function __construct()
    {
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
        // logger::log('folders= ' . json_encode($pagesFolders));
        // file_put_contents('./log.txt', 'folders= ' . json_encode($pagesFolders) . PHP_EOL, FILE_APPEND);
        foreach ($pagesFolders as $folder) {
            $mediaObject = $this->getMediaObjectFromFolder($folder);
            $mediaObject->images = $sf->getListOfFiles($folder, '*.webm');
            $mediaObject = $this->setIfQuizesAnswered($mediaObject, $answers, $playerID);
            $list[] = $mediaObject;
            // logger::log('$mediaObject= ' . json_encode($mediaObject));
            //file_put_contents('./log.txt', 'getMediaObjectFromFolder' .PHP_EOL, FILE_APPEND);
        }
        // logger::log('fun compareBySortOrder= ' . compareBySortOrder($list[2], $list[1]));        
        logger::log('count($list) = ' . count($list));
        // logger::log('$list = ' . json_encode($list));
        usort($list, function ($a, $b) {
            return $a->sortOrder - $b->sortOrder;
        });
        $maxID = 0;
        $listSorted = [];
        foreach ($list as $value) {
            if ($value->quizID > $maxID) $maxID = $value->quizID;
            if (key_exists($value->quizID, $listSorted)) {
                logger::log('ERROR: quizID doublicate: ' . $value->quizID);
                continue;
            }
            $listSorted[$value->quizID] = $value;
        }
        logger::log('max quiz ID = ' . $maxID);
        //file_put_contents($this->quizes, json_encode($listSorted, JSON_PRETTY_PRINT));
        //logger::log('$$listSorted = ' . json_encode($listSorted));

        // $listToSort = [];
        // foreach ($list as $value) {
        //     $listToSort[$value->sortOrder] = $value;
        // }
        // logger::log('count($listToSort) = ' . count($listToSort));
        // ksort($listToSort);
        // $list = [];
        // foreach ($listToSort as $value) {
        //     $list[$value->quizID] = $value;
        // }
        // logger::log('count($list) = ' . count($list));
        // usort($list, 'compareBySortOrder');
        return $listSorted;
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
        $object->question    = $objctFromFile->question;
        $object->buttonCaption = $objctFromFile->buttonCaption;
        $object->quizID      = $objctFromFile->quizID;
        $object->forHim      = $objctFromFile->forHim;
        $object->forHer      = $objctFromFile->forHer;
        $object->colorButton = $objctFromFile->colorButton;
        if (property_exists($objctFromFile, "sortOrder")) {
            $object->sortOrder = $objctFromFile->sortOrder;
        }
        $object->group      = $objctFromFile->group;
        return $object;
    }

    public function getListOfPlayers(): array
    {
        $list = [];
        if (file_exists($this->playersFileName) === false) {
            for ($i = 1; $i <= 4; $i++) {
                $newPlayer = new player;
                $list[] = $newPlayer;
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
                $list[$player->ID] = $player;
            }
        }
        // logger::log('players read: '. json_encode($list,JSON_PRETTY_PRINT));
        return $list;
    }

    public function saveListOfPlayers(array $list): void
    {
        file_put_contents($this->playersFileName, json_encode($list));
    }

    function readGame(): game
    {
        logger::log('readGame ===');
        $fileContent = file_get_contents($this->gameFileName);
        $objectFromFile = json_decode($fileContent);
        $game = new game;
        try {
            if (property_exists($objectFromFile, 'currentPlayerID')) {
                $game->currentPlayerID = $objectFromFile->currentPlayerID;
                $players = $this->getListOfPlayers();
                $game->currentPlayer = $players[$game->currentPlayerID];
                $game->quizID = $objectFromFile->quizID;
                $game->lastAnsweredPlayerID = $objectFromFile->lastAnsweredPlayerID;
                $game->lastAnsweredQuizID = $objectFromFile->lastAnsweredQuizID;
                $game->lastAnsweredMediaPath = $objectFromFile->lastAnsweredMediaPath;
            }
        } catch (\Throwable $th) {
            logger::log('error in getting player');
        }
        return $game;
    }

    function saveGame(): void
    {
        $gameJson = json_encode(constants::getGame(), JSON_PRETTY_PRINT);
        file_put_contents($this->gameFileName, $gameJson);
        logger::log('Game saved.');
    }

    function getAnswers(): array
    {
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
        logger::log('answer v: ' . $pathToVideo);
        $obj = $this->getAnswers();
        $game = constants::getGame();
        $newAnswer = new answer();

        $newAnswer->playerID = $game->currentPlayerID;
        $pathToVideo = str_replace('\/', '/', $pathToVideo);
        $newAnswer->pathToVideo = $pathToVideo;
        logger::log('saveChoice 1 ' . json_encode(constants::getGame()));
        $newAnswer->quizID = $game->quizID;
        logger::log('saveChoice 2 ');
        $obj[] = $newAnswer;
        $answersJson = json_encode($obj, JSON_PRETTY_PRINT);
        file_put_contents($this->answersFileName, $answersJson);

        $game->lastAnsweredQuizID = $game->quizID;
        $game->lastAnsweredPlayerID = $game->currentPlayerID;
        $game->lastAnsweredMediaPath = $pathToVideo;
        $this->saveGame();

        logger::log('answer saved');
    }

    public function setIfQuizesAnswered(
        folderMedia $mediaObject,
        array $answers,
        int $playerID
    ): folderMedia {
        foreach ($answers as $answer) {
            if ($mediaObject->quizID === $answer->quizID && $answer->playerID === $playerID) {
                $mediaObject->alreadyAnswered = true;
                return $mediaObject;
            }
        }
        return $mediaObject;
    }
}

function compareBySortOrder($a, $b)
{
    return $a->sortOrder - $b->sortOrder;
}
