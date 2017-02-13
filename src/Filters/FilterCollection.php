<?php

namespace Permafrost\TemplatedText\Filters;

use Permafrost\TemplatedText\Filters\Filter;

class FilterCollection implements \Countable
{

    protected $filters = [];

    public function count()
    {
        return count($this->filters);
    }

    public function hasFilter($name)
    {
        return isset($this->filters[$name]);
    }

    public function add($name, $filter)
    {
        $this->filters[$name] = $filter;
        return $this;
    }

    public function addNewFilter($name, callable $callback)
    {
        $this->add($name, new Filter($name, $callback));
        return $this;
    }

    public function all()
    {
        return $this->filters;
    }

    public function only(array $names)
    {
        $result = [];
        foreach($this->all() as $name=>$filter) {
            if (in_array($name, $names))
                $result[$name] = $filter;
        }
        return $result;
    }

    public function single($name)
    {
        return $this->filters[$name];
    }

    public function merge(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        return $this;
    }

}
