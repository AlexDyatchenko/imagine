<?php

namespace imagine;

use constants;

require_once './classes/outputProcessor.php';

class quizChoicePage
{
    private dbFunctions $dbFunctions;
    private genders $userGender;

    public function __construct()
    {
        $this->dbFunctions = new dbFunctions;
    }

    public function generatePage(): string
    {
        file_put_contents('./log.txt', '0' . PHP_EOL, FILE_APPEND);
        $allButtons = '';
        $list = $this->dbFunctions->getListOfMedia();
        logger::log('in Quiz page count($list) = ' . count($list));
        // file_put_contents('./log.txt', json_encode($list).PHP_EOL, FILE_APPEND);
        // logger::log('game =' . json_encode(constants::getGame()));
        $game = constants::getGame();
        $this->userGender = $game->currentPlayer->gender;
        logger::log('current player = ' . $game->currentPlayer->name);
        if ($this->userGender == genders::female) {
            logger::log('user gender = female');
        } elseif ($this->userGender == genders::male) {
            logger::log('user gender = male');
        } else {
            logger::log('user gender = unknown');
        }
        $allButtons = '';
        foreach ($list as $media) {
            $button = $this->addButtonForMedia($media, $game);
            // logger::log('$button = ' . json_encode($button));
            // file_put_contents('./log.txt', (string)$media->quizID . $button .PHP_EOL, FILE_APPEND);
            $allButtons .= $button;
        }
        // file_put_contents('./log.txt', 'button = ' . $allButtons.PHP_EOL, FILE_APPEND);

        $quizChoicePage = new outputProcessor('pages/quizChoicePage.html');
        $quizChoicePage->setParameter($allButtons);
        $quizChoicePage->setParameter($this->generatePlayers(), 'players');

        $backgroundVideoPath = 'media/27708422a.webm';
        if (!file_exists($backgroundVideoPath)) {
            $backgroundVideoPath = 'mediaTemp/palm.mp4';
        }
        logger::log('getLastAnsweredMadiaPath = ' . $game->getLastAnsweredMadiaPath());
        logger::log('getLastAnsweredMadiaPathOnly = ' . $game->lastAnsweredMediaPath);
        if ($game->getLastAnsweredMadiaPath() !== '') {
            $backgroundVideoPath = $game->getLastAnsweredMadiaPath();
        }
        $quizChoicePage->setParameter($backgroundVideoPath, 'backgroundVideoPath');

        return $quizChoicePage->echo();
    }

    public function generatePlayers(): string
    {
        $playersBlock = new outputProcessor('pages/players.html');
        $playersArray = $this->dbFunctions->getListOfPlayers();
        // logger::log('players===' . json_encode($playersArray));
        $playersHTML = '';
        $game = constants::getGame();
        $player = new player;
        $currentPlayerID = $game->currentPlayerID;
        if ($currentPlayerID == 0) {
            // $currentPlayerID = 1;  check it
        }
        foreach ($playersArray as $player) {
            $playerHTML = new outputProcessor('pages/playerButton.html');
            $playerHTML->setParameter($player->ID, 'playerID');
            $playerHTML->setParameter($player->name, 'playerName');
            if ($currentPlayerID === $player->ID) {
                $playerHTML->setParameter('checked', 'currentPlayer');
            } else {
                $playerHTML->setParameter('', 'currentPlayer');
            }
            $playersHTML .= $playerHTML->echo();
            // logger::log(json_encode($player));
        }
        $playersBlock->setParameter($playersHTML, 'buttons');
        // logger::log(json_encode($playersBlock->echo()));
        // logger::log($playersHTML);
        return $playersBlock->echo();
    }

    public function addButtonForMedia(folderMedia $mediaItem, game $game): string
    {
        if (file_exists('./pages/mediaButton.html') === false) {
            logger::log('skipping folder ');
            return ''; //skipping folder!
        }
        $buttonTemplate = new outputProcessor('./pages/mediaButton.html');
        $buttonTemplate->setParameter($mediaItem->buttonCaption);
        $buttonTemplate->setParameter($mediaItem->quizID, 'quizID');
        $enabled = true;
        if (($this->userGender === genders::male && $mediaItem->forHim === false)
            || ($this->userGender === genders::female && $mediaItem->forHer === false)
        ) {
            $enabled = false;
            logger::log("quiz disabled by gender " . $mediaItem->quizID);
        }
        if ($mediaItem->alreadyAnswered) {
            $enabled = false;
            $buttonTemplate->setParameter('alreadyAnswered', 'alreadyAnswered');
            logger::log('Already answered web: ' . $mediaItem->quizID);
        } elseif ($mediaItem->alreadyAnsweredBySomeone) {
            $buttonTemplate->setParameter('alreadyAnsweredBySomeone', 'alreadyAnswered');
            logger::log('Already answered by semoone web: ' . $mediaItem->quizID);
        } else {
            $buttonTemplate->setParameter('', 'alreadyAnswered');
        }

        if ($mediaItem->quizID === $game->lastAnsweredQuizID()) {
            $enabled = false;
            $buttonTemplate->setParameter('lastAnswered', 'lastAnswered');
        } else {
            $buttonTemplate->setParameter('', 'lastAnswered');
        }
        if ($enabled) {
            $buttonTemplate->setParameter('', 'disabled');
        } else {
            $buttonTemplate->setParameter('disabled', 'disabled');
        }
        #used
        //   file_put_contents('./log.txt', '3===' . json_encode($buttonTemplate->echo()).PHP_EOL, FILE_APPEND);
        return $buttonTemplate->echo();
    }
}
