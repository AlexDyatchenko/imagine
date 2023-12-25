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
        if ($this->lastAnsweredPlayerID === $this->currentPlayerID) {
            return $this->lastAnsweredMediaPath;
        }
        return '';
    }

    public function lastAnsweredQuizID() : int
    {
        if ($this->lastAnsweredQuizID !== 0 and $this->lastAnsweredPlayerID === $this->currentPlayerID) {
            return $this->lastAnsweredQuizID;
        }
        return 0;
    }
}

