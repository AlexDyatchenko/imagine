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
        $output = file_get_contents($this->path . '/descroption.json');
        //str_replace
        $files = $this->getListOfFiles();
        foreach ($files as $file) {
            $output .= $this->generateOneBlock($file);
        }
        return $output;        
    }


    public function getListOfFiles(string $directory) : array
    {
        $files = array();
        if (is_file($files)) {
            $filesInDir = scandir($directory);
            if ($filesInDir !== false) {                                
                foreach ($filesInDir as $file) {
                    // Check if it's a directory (not . or ..)
                    if (is_file($directory . '/' . $file) && $file != "." && $file != "..") {
                        $files[] = $file;
                    }
                }                        
            } else {
                echo "Failed to read the directory.";
            }
        } else {
            echo "The directory does not exist.";
        }
        return $files;
    }

    public function generateOneBlock(string $file) : string
    {
        return $file;
    }
}