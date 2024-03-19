<?php

namespace imagine;

class game
{
    public int    $currentPlayerID = 0;
    public player $currentPlayer;
    public genders $currentGender;
    public int    $quizID;
    public int    $lastAnsweredQuizID = 0;
    public string $lastAnsweredMediaPath = '';
    public int    $lastAnsweredPlayerID = 0;

    public function getLastAnsweredMadiaPath() : string
    {
        $lastAnsweredMadiaPath = '';
        $db = new dbFunctions;
        $answers = $db->getAnswers(); 
        foreach ($answers as $answer) {
            if ($answer->playerID === $this->currentPlayerID) {
                $lastAnsweredMadiaPath = $answer->pathToVideo;
            }
        }
        // if ($this->lastAnsweredPlayerID === $this->currentPlayerID) {
        //     return $this->lastAnsweredMediaPath;
        // }
        return $lastAnsweredMadiaPath;
    }

    public function lastAnsweredQuizID() : int
    {

        $this->lastAnsweredQuizID = 0;
        $db = new dbFunctions;
        $answers = $db->getAnswers(); 
        foreach ($answers as $answer) {
            if ($answer->playerID === $this->currentPlayerID) {
                $this->lastAnsweredQuizID = $answer->quizID;
            }
        }
        return $this->lastAnsweredQuizID;
    }
}

