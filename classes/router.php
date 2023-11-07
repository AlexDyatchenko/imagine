<?php

use imagine\outputProcessor;
use imagine\quizChoicePage;
use imagine\videoQuizPage;

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
        } else {
            require_once './classes/quizChoicePage.php';
            $page = new quizChoicePage();
        }
        $outputProcessor->setParameter($page->generatePage());
        echo $outputProcessor->echo();
    }    
}