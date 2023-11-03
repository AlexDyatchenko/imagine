<?php
namespace imagine;
class outputProcessor 
{
    private string $body = '';
    private string $template = '';

    public function __construct(string $template)
    {
        $this->template = $template;
        // echo '!!$this->template' . $this->template . PHP_EOL;
        // echo $index;
    }

    public function addToBody(string $html): void
    {
        $this->body .= $html;
    }

    public function getPageContent(): string
    {
        return $this->body;
    }

    public function echo(): string
    {
        // echo '==$this->template' . $this->template . PHP_EOL;
        if (file_exists($this->template) === false) {
            file_put_contents('./log.txt', 'No content! ' . $this->template .PHP_EOL, FILE_APPEND);
            return '';
        }
        $output = file_get_contents($this->template);
        $output = str_replace('{body}', $this->body, $output);
        file_put_contents('./log.txt', $output.PHP_EOL, FILE_APPEND);
        return $output;
    }
}