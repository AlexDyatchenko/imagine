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
        $this->outputProcessor = new outputProcessor('./video.html');
    }
    
    public function generatePage() : string
    {
        file_put_contents('./log.txt', '0'.PHP_EOL, FILE_APPEND);
        $list = $this->dbFunctions->getListOfMedia();
        file_put_contents('./log.txt', json_encode($list).PHP_EOL, FILE_APPEND);
        $allButtons = '';
        foreach ($list as $media) {
            file_put_contents('./log.txt', '1'.PHP_EOL, FILE_APPEND);
            $allButtons .= $this->addButtonForMedia($media);
            $this->outputProcessor->addToBody($media);    
        }  
        return $this->outputProcessor->getPageContent();
    }

    public function addButtonForMedia(folderMedia $mediaItem): string
    {
        $buttonTemplate = new outputProcessor('./pages/mediaButton.html');
        $buttonTemplate->addtoBody($mediaItem->description);
        return $buttonTemplate->getPageContent();
    }
}