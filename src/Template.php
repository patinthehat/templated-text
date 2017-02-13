<?php

namespace Permafrost\TemplatedText;

use Permafrost\TemplatedText\Filters\Filter;

abstract class Template
{

    public $template;
    public $variables = [];
    public $filters = [];

    protected $setTemplate = false;

    public function __construct()
    {
        //
    }

    public function hasVariable($name)
    {
        return isset($this->variables[$name]);
    }

    public function getVariable($name)
    {
        return $this->variables[$name];
    }

    public function template($content)
    {
        $this->setTemplate = true;
        $this->template = $content;
        return $this;
    }

    public function variable($name, $value)
    {
        $this->variables[$name] = $value;
        return $this;
    }

    public function filter($name, callable $callback)
    {
        $filter = new Filter($name, $callback);
        $this->filters[$name] = $filter;
        return $this;
    }

    abstract function process();



}
