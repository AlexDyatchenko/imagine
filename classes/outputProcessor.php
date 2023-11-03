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

    public function echo(): void
    {
        // echo '==$this->template' . $this->template . PHP_EOL;
        $output = file_get_contents($this->template);
        $output = str_replace('{body}', $this->body, $output);
        echo $output;
    }
}