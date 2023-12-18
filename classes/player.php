<?php

namespace imagine;

enum genders: int {
    case unknown = 0;
    case male = 1;
    case female = 2;
}
class player
{
    public string $name = '';
    public int $ID = -1;
    public genders $gender = genders::unknown; 
}
