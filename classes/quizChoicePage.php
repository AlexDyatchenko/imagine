<?php

namespace imagine;
require_once './classes/outputProcessor.php';

class quizChoicePage
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

        $allButtons = '';        
        foreach ($list as $media) {            
            $button = $this->addButtonForMedia($media);
            file_put_contents('./log.txt', (string)$media->quizID . $button .PHP_EOL, FILE_APPEND);
            $allButtons .= $button;
        }  
        file_put_contents('./log.txt', 'button = ' . $allButtons.PHP_EOL, FILE_APPEND);
        
        $quizChoicePage = new outputProcessor('pages/quizChoicePage.html');
        $quizChoicePage->setParameter($allButtons);

        return $quizChoicePage->echo();
    }

    public function addButtonForMedia(folderMedia $mediaItem): string
    {
        if (file_exists('./pages/mediaButton.html') === false) {
            return ''; //skipping folder!
        }
        $buttonTemplate = new outputProcessor('./pages/mediaButton.html');
        $buttonTemplate->setParameter($mediaItem->description);
        $buttonTemplate->setParameter($mediaItem->quizID, 'quizID');

          file_put_contents('./log.txt', '3' . json_encode($buttonTemplate->echo()).PHP_EOL, FILE_APPEND);
        return $buttonTemplate->echo();
    }
}