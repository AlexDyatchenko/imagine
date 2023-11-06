<?php
namespace imagine;

use systemFunctions;

require_once('./classes/systemFunctions.php');
require_once('./classes/folderMedia.php');

class dbFunctions
{
    public string $folder = './Media';

    public function getListOfMedia() : array
    {
        $list = [];
        $sf = new systemFunctions();
        $pagesFolders = $sf->getListOfFolders($this->folder);
        file_put_contents('./log.txt', 'folders= ' . json_encode($pagesFolders) .PHP_EOL, FILE_APPEND);
        foreach ($pagesFolders as $folder) {
            $list[] = $this->getMediaObjectFromFolder($folder);
            //file_put_contents('./log.txt', 'getMediaObjectFromFolder' .PHP_EOL, FILE_APPEND);
        }
        return $list;
    }

    public function getMediaObjectFromFolder(string $folder) : folderMedia
    {
        
        
        $object = new folderMedia;
        if (!file_exists($folder . '/description.json')) {
            return $object;
        }        
        $fileContent = file_get_contents($folder . '/description.json');        
        $objctFromFile = json_decode($fileContent);
        $object->description = $objctFromFile->description;
        
        return $object;
    }    
}