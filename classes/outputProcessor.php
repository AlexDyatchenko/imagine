<?php
namespace imagine;
class outputProcessor 
{
    private string $body = '';
    private string $template = '';

    public function __construct(string $template)
    {
        $this->template = $template;
        if (file_exists($this->template) === false) {
            file_put_contents('./log.txt', 'No content! ' . $this->template .PHP_EOL, FILE_APPEND);
            return '';
        }
        $this->body = file_get_contents($this->template);
   }

    public function setParameter(string $html, string $parameterName = 'body'): void
    {
        $this->body = str_replace("{" . $parameterName . "}", $html, $this->body);
    }

    public function getPageContent(): string
    {
        return $this->body;
    }

    public function echo(): string
    {
        // echo '==$this->template' . $this->template . PHP_EOL;
        // file_put_contents('./log.txt', $this->body .PHP_EOL, FILE_APPEND);
        return $this->body;
    }
}