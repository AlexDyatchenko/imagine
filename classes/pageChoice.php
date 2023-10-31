<?php

namespace imagine;
require_once './classes/outputProcessor.php';
use stdClass;

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
        
    }
    
    public function getListOfMedia(Type $var = null) : stdClass
    {
        $list = new stdClass;
        $pagesFolders = $pages->getListOfFolders();
        foreach ($pagesFolders as $folder) {
            $page = new page('./pages/' . $folder);
            $videoBlock = $page->generate();
            $this->addButtonForFolder($videoBlock);    
        }
    }

    public function getObjectFromFolder(string $folder) : stdClass
    {
        $object = new stdClass;
        if (file_exists(folder . 'description.json'))
        {
            $output = file_get_contents($this->path . '/description.json');            
        } else {
            $output = '';
        }

        $object->description = 
    }    

    public function addButtonForFolder(string $folder): string
    {
        $button = '<button>Butt1</button>';
        $this->outputProcessor->addToBody($button);
    }
}