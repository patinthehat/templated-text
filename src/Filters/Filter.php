<?php

namespace Permafrost\TemplatedText\Filters;

class Filter
{
    protected $filter;

    public function __construct($name, callable $filterFunction)
    {
        $this->filter = $filterFunction;
    }

    public function apply($data)
    {
        return call_user_func($this->filter, $data);
    }

}
