<?php
class systemFunctions
{

    public function getFoldersList(string $folder): array
    {
        return [];
    }

    public function getListOfFiles(string $directory, string $wildcard = '*.*'): array
    {
        $filesArray = array();
        $files = glob($directory . '/' . $wildcard);
        $message = "searching files matching $directory . '/' . $wildcard.";
        file_put_contents('./log.txt', $message . PHP_EOL, FILE_APPEND);
        if ($files !== false) {
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $filesArray[] = $file;
                }
            } else {
                $message = "No files matching '$wildcard' found in $directory.";
                file_put_contents('./log.txt', $message . PHP_EOL, FILE_APPEND);
            }
        } else {
            $message = "Failed to read the directory with glob().";
            file_put_contents('./log.txt', $message . PHP_EOL, FILE_APPEND);
        }

        //if (is_file($files)) {
        // echo '$directory = '. $directory . PHP_EOL;
        // $filesInDir = scandir($directory);
        // if ($filesInDir !== false) {
        //     foreach ($filesInDir as $file) {
        //         // Check if it's a directory (not . or ..)
        //         if (is_file($directory . '/' . $file) && $file != "." && $file != "..") {
        //             $files[] = $directory . DIRECTORY_SEPARATOR . $file;
        //         }
        //     }
        // } else {
        //     echo "Failed to read the directory.";
        // }
        // } else {
        //     echo "The directory does not exist.";
        // }
        return $filesArray;
    }

    public function getListOfFolders(string $folder): array
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
            echo "The directory does not exist. " . $folder;
        }
        return $folders;
    }
}
