<?php

namespace imagine;

class playersController
{
    public array $players;

    public function getListOfPlayers() : array
    {
        $dbFunctions = new dbFunctions;
        $this->players = $dbFunctions->getListOfPlayers();
        return $this->players;
    }

    public function saveListOfPlayers(): void
    {
        $dbFunctions = new dbFunctions;
        $this->players = $dbFunctions->saveListOfPlayers($this->players);
    }

    public function changePlayer(
        int $index, 
        string $name,
        int $gender) : void
    {
        $players = $this->getListOfPlayers();
        $player = $players[$index-1];
        $player->name = $name;
        $player->gender = genders::tryFrom($gender) ?? genders::male;
    }
}