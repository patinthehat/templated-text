<?php

namespace Permafrost;

abstract class Template
{

    public $template;
    public $replacements = [];
    
    public function __construct()
    {
        //
    }
    
    public function withTemplate($content)
    {
        $this->template = $content;
        return $this;
    }
    
    public function replacement($varName, $replacement)
    {
        $this->replacements[$varName] = $replacement;
        return $this;
    }
    
    abstract function process();
    
   

}
