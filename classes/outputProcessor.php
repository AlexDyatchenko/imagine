<?php
namespace imagine;
class outputProcessor 
{
    private string $body = '';
    private string $template = '';

    public function __constructor(string $template)
    {
        $this->template = $template;
        // echo $index;
    }

    public function addToBody(string $html): void
    {
        $this->body .= $html;
    }

    public function getBody(): string
    {
        return $body;
    }

    public function echo(): void
    {
        $output = file_get_contents($this->template);
        $output = str_replace('{body}', $this->body, $output);
        echo $output;
    }
}