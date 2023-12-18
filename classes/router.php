<?php

use imagine\outputProcessor;
use imagine\playersController;
use imagine\quizChoicePage;
use imagine\videoQuizPage;
use imagine\apiResponse;
use imagine\dbFunctions;
use imagine\game;
use imagine\logger;

class router
{
    public function Init(): void
    {
        $db = new dbFunctions;
        $GLOBALS['game'] = $db->readGame();
    }

    public function route(): void
    {
        $this->Init();
        $queryString = $_SERVER['QUERY_STRING'];

        // Parse the query string into an associative array
        parse_str($queryString, $queryParameters);

        // Convert the associative array to a stdClass object
        $queryObject = (object) $queryParameters;

        // Example: Accessing individual parameters
        $outputProcessor = new outputProcessor('index.html');
        if (property_exists($queryObject, 'player')) {
            $game = constants::getGame();
            $game->currentPlayerID = constants::getGame()->currentPlayerID;
            $db = new dbFunctions;
            $players = $db->getListOfPlayers();
            $game->currentGender = $players[$game->currentPlayerID]->gender;
            $db = new dbFunctions;
            $db->saveGame();
        }
        if (property_exists($queryObject, 'setCurrentPlayer')) {
            $game = constants::getGame();
            $game->currentPlayerID = (int)$queryObject->setCurrentPlayer;
            $db = new dbFunctions;
            $db->saveGame();
        }
        $entityBody = file_get_contents('php://input');
        $requestBody = json_decode($entityBody);
        logger::log('router start' . json_encode($queryObject) . ' :: ' . $entityBody);
        if (property_exists($queryObject, 'quiz')) {
            $page = new videoQuizPage($queryObject->quiz);
        } elseif (property_exists($queryObject, 'fn')) {
            $page = new apiResponse();
            if ($queryObject->fn === 'updatePlayer') {
                require_once './classes/playersController.php';
                $playersController = new playersController();
                $gender = $requestBody->gender;
                $name = $requestBody->name;
                $id = $requestBody->id;
                $playersController->changePlayer($id, $name, $gender);
            } elseif ($queryObject->fn === 'getPlayersHtml') {
                $quizChoicePage = new quizChoicePage;
                echo $quizChoicePage->generatePlayers();
                exit;
            } elseif (
                $queryObject->fn === 'saveChoice' ||
                (is_object($requestBody) && property_exists($requestBody, 'fn') && $requestBody->fn = 'saveChoice')
            ) {
                logger::log('ffff');
                $db = new dbFunctions;
                $db->saveChoice($requestBody->pathToVideo);
                echo '{"response": "answer saved"}';
                exit;
            }
        } else {
            require_once './classes/quizChoicePage.php';
            $page = new quizChoicePage();
        }
        $outputProcessor->setParameter($page->generatePage());
        echo $outputProcessor->echo();
    }
}
