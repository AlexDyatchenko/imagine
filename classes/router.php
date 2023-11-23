<?php

use imagine\outputProcessor;
use imagine\playersController;
use imagine\quizChoicePage;
use imagine\videoQuizPage;
use imagine\apiResponse;

class router
{
    public function route(): void
    {
        $queryString = $_SERVER['QUERY_STRING'];

        // Parse the query string into an associative array
        parse_str($queryString, $queryParameters);

        // Convert the associative array to a stdClass object
        $queryObject = (object) $queryParameters;

        // Example: Accessing individual parameters
        $outputProcessor = new outputProcessor('index.html');
        if (property_exists($queryObject, 'quiz')) {
            require_once './classes/videoQuizPage.php';
            $page = new videoQuizPage($queryObject->quiz);
        } elseif (property_exists($queryObject, 'fn')) {
            $page = new apiResponse();
            if ($queryObject->fn === 'updatePlayer') {
                $entityBody = file_get_contents('php://input');
                $requestBody = json_decode($entityBody); 
                require_once './classes/playersController.php';
                $playersController = new playersController();
                $gender = $requestBody->gender;
                $name = $requestBody->name;
                $id = $requestBody->id;
                $playersController->changePlayer($id, $name, $gender);
            }
        } else {
            require_once './classes/quizChoicePage.php';
            $page = new quizChoicePage();
        }
        $outputProcessor->setParameter($page->generatePage());
        echo $outputProcessor->echo();
    }
}
