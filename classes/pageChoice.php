<?php

namespace imagine;
require_once './classes/outputProcessor.php';
require_once './classes/dbFunctions.php';

class pageChoice
{
    private outputProcessor $outputProcessor;
    private dbFunctions $dbFunctions;

    public function __construct()
    {
        $this->dbFunctions = new dbFunctions;        
    }
    
    public function generatePage() : string
    {
        file_put_contents('./log.txt', '0'.PHP_EOL, FILE_APPEND);
        $allButtons = '';
        $list = $this->dbFunctions->getListOfMedia();
        file_put_contents('./log.txt', json_encode($list).PHP_EOL, FILE_APPEND);
        foreach ($list as $media) {
            
            $button = $this->addButtonForMedia($media);
            file_put_contents('./log.txt', '1 ' . $button .PHP_EOL, FILE_APPEND);
            $allButtons .= $button;
        }  
        file_put_contents('./log.txt', 'button = ' . $allButtons.PHP_EOL, FILE_APPEND);
        return $allButtons;
    }

    public function addButtonForMedia(folderMedia $mediaItem): string
    {
        $buttonTemplate = new outputProcessor('mediaButton.html');
        $buttonTemplate->addtoBody($mediaItem->description);
          file_put_contents('./log.txt', '3' . json_encode($buttonTemplate->echo()).PHP_EOL, FILE_APPEND);
        return $buttonTemplate->echo();
    }
}