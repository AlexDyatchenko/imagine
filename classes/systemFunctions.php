<?php
class systemFunctions
{

    public function getFoldersList(string $folder) : array
    {
        return [];
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

    public function getListOfFolders(string $folder) : array
    {
        $folders = array();
        if (is_dir($folder)) {
            $files = scandir($folder);
            if ($files !== false) {                                
                foreach ($files as $file) {
                    // Check if it's a directory (not . or ..)
                    $fullFileName = $folder . '/' . $file;
                    if (is_dir($fullFileName) && $file != "." && $file != "..") {
                        $folders[] = $fullFileName;
                    }
                }                        
            } else {
                echo "Failed to read the directory.";
            }
        } else {
            echo "The directory does not exist.";
        }
        return $folders;
    }
}