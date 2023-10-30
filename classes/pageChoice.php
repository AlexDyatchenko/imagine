<?php

namespace imagine;
require_once './classes/outputProcessor.php';

class pageChoice
{
    private outputProcessor $outputProcessor;
    private string $folder = '';

    public function __construct(string $folder)
    {
        $this->folder = $folder;
    }
    
    public function generatePage() : string
    {
        $pagesFolders = $pages->getListOfFolders();
        foreach ($pagesFolders as $folder) {
            $page = new page('./pages/' . $folder);
            $videoBlock = $page->generate();
            $this->addButtonForFolder($videoBlock);    
        }
    }

    public function addButtonForFolder(string $folder): string
    {
        $button = '<button>Butt1</button>';
        $this->outputProcessor->addToBody($button);
    }
}