<?php

namespace imagine;

use stdClass;

require_once './classes/outputProcessor.php';

class apiResponse
{
    public bool $result;

    public function generatePage() : string 
    {
        $response = new stdClass;
        $response->code = 200;
        $response->description = 'done';
        return json_encode($response);    
    }
}