<?php
namespace imagine;

require_once './classes/video.php';

class Page
{
    private string $path = '';

    public function __construct(string $path)
    {
        $this->path = $path;
        //echo 'path = ' . $path . PHP_EOL;
    }

    public function generate(): string
    {
        if (file_exists($this->path . '/description.json'))
        {
            $output = file_get_contents($this->path . '/description.json');            
        } else {
            $output = '';
        }
        //str_replace
        $output .= '<div class="container">';
        $files = $this->getListOfFiles($this->path);
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


    public function getListOfFiles(string $directory) : array
    {
        $files = array();
        //if (is_file($files)) {
            // echo '$directory = '. $directory . PHP_EOL;
            $filesInDir = scandir($directory);
            if ($filesInDir !== false) {                                
                foreach ($filesInDir as $file) {
                    // Check if it's a directory (not . or ..)
                    if (is_file($directory . '/' . $file) && $file != "." && $file != "..") {
                        $files[] = $directory . DIRECTORY_SEPARATOR . $file;
                    }
                }                        
            } else {
                echo "Failed to read the directory.";
            }
        // } else {
        //     echo "The directory does not exist.";
        // }
        return $files;
    }

    public function generateOneBlock(string $file) : string
    {
        $output = file_get_contents('./video1.html');            
        $output = str_replace('{videoFile}', $file, $output);
        return $output;
    }
}