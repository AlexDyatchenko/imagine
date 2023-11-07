<?php

namespace imagine;

class pages
{
    public function getListOfFolders(string $directory) : array
    {
        $folders = array();
        if (is_dir($directory)) {
            $files = scandir($directory);
            if ($files !== false) {                                
                foreach ($files as $file) {
                    // Check if it's a directory (not . or ..)
                    if (is_dir($directory . '/' . $file) && $file != "." && $file != "..") {
                        $folders[] = $file;
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