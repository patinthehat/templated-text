<?php

namespace Permafrost\TemplatedText\Filters;

class FilterPipeline
{
    protected $filters = [];

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function execute($data)
    {
        $result = $data;
        if (count($this->filters) == 0)
            return $result;

        foreach($this->filters as $filter)
            $result = $filter->apply($result);

        return $result;
    }

    public function add(Filter $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

}