<?php
namespace imagine;

use systemFunctions;

require_once './classes/video.php';
require_once './classes/systemFunctions.php';

class PageVideo
{
    private string $path = '';

    public function __construct(string $path)
    {
        $this->path = $path;
        //echo 'path = ' . $path . PHP_EOL;
    }

    public function generatePage(): string
    {
        if (file_exists($this->path . '/description.json'))
        {
            $output = file_get_contents($this->path . '/description.json');            
        } else {
            $output = '';
        }
        //str_replace
        $output .= '<div class="container">';
        $sf = new systemFunctions;
        $files = $sf->getListOfFiles($this->path);
        // $index = 
        foreach ($files as $file) {
            $output .= $this->generateOneBlock($file);
        }
        $output .= '</div>';
        return $output;        
    }

    public function generate() : string
    {
        $pagesFolders = $pages->getListOfFolders();
        foreach ($pagesFolders as $folder) {
            $page = new page('./pages/' . $folder);
            $videoBlock = $page->generate();
            $this->addButtonForFolder($videoBlock);    
        }
    }

    public function generateOneBlock(string $file) : string
    {
        $output = file_get_contents('./video1.html');            
        $output = str_replace('{videoFile}', $file, $output);
        return $output;
    }
}