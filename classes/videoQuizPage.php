<?php

namespace imagine;

class videoQuizPage
{
    public folderMedia $media;

    public function __construct(int $quizID)
    {
        $dbFunctions = new dbFunctions;
        $list = $dbFunctions->getListOfMedia();
        if (key_exists($quizID, $list) === false) {
            file_put_contents('./log.txt', 'no image !!!' . PHP_EOL, FILE_APPEND);
            return;
        }
        $this->media = $list[$quizID];
        file_put_contents('./log.txt', json_encode($this->media) . PHP_EOL, FILE_APPEND);
    }

    public function generatePage(): string
    {
        if (isset($this->media) === false) {
            return 'error!';
        }
        $videoQuiz = new outputProcessor('./pages/videoQuiz.html');        
        $videoQuiz->setParameter($this->media->description, 'Description');
        // $video1Row = new outputProcessor('./pages/video1Row.html');

        $videos = '';
        // $videos1row = '';
        $index = 0;
        foreach ($this->media->images as $value) {
            $index++;
            $videos .= $this->generateOneVideo($value);
            // if ($index % 2) {
            //     //file_put_contents('./log.txt', $videos1row . PHP_EOL, FILE_APPEND);                    
            //     $videos .= $videos1row->echo();

            //     $videos1row = new outputProcessor('./pages/video1Row.html');                
            // }
        }
        $videoQuiz->setParameter($videos);
        return $videoQuiz->echo();
    }

    public function generateOneVideo(string $file): string
    {
        $oneVideoBlock = new outputProcessor('./pages/oneVideo.html');
        $oneVideoBlock->setParameter($file, 'videoFile');
        file_put_contents('./log.txt', '3' . json_encode($oneVideoBlock->echo()) . PHP_EOL, FILE_APPEND);
        return $oneVideoBlock->echo();
    }
}
