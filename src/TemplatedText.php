<?php
namespace Permafrost\TemplatedText;

use Permafrost\TemplatedText\Filters\Filter;
use Permafrost\TemplatedText\Filters\FilterCollection;
use Permafrost\TemplatedText\Filters\FilterPipeline;

class TemplatedText extends Template
{
    protected $builtins;
    protected $customFilters;

    public function __construct()
    {
        $this->builtins = new FilterCollection;
        $this->customFilters = new FilterCollection;

        $this->builtins
            ->addNewFilter('uppercase', function($v) { return strtoupper($v); })
            ->addNewFilter('lowercase', function($v) { return strtolower($v); })
            ->addNewFilter('quote',     function($v) { return '"'.$v.'"'; })
            ->addNewFilter('aquote',    function($v) { return '->'.$v.'<-'; })
            ->addNewFilter('ucfirst',   function($v) { return ucfirst($v); });
    }

    public function filter($name, callable $callback)
    {
        $filter = new Filter($name, $callback);
        $this->filters[$name] = $filter;
        $this->customFilters->add($name, $filter);

        return $this;
    }

    public function process()
    {
        if (!$this->setTemplate)
            throw new \Exception('Must set template before calling process()');

        $result = $this->template;
        $re = "/\{\{([a-zA-Z0-9_\-]+)(\}\}|\s*\|([\s\|a-zA-Z0-9_\-]+)\}\})/";
        $matches = preg_match_all($re, $result, $m);
        for($i = 0; $i < $matches; $i++) {
            echo "RESULT=$result\n";
            $toReplace = $m[0][$i];
            $varName = $m[1][$i];
            $filters = str_replace(' ', '', $m[3][$i]);
            $hasFilters = (strlen($filters)>0);

            if ($this->hasVariable($varName)) {
                if (!$hasFilters) {
                    $result = preg_replace("/". preg_quote($toReplace)."/", $this->getVariable($varName), $result, 1);
                } else {
                    $fp = new FilterPipeline([]);
                    $filterlist = explode('|', $filters);

                    foreach($filterlist as $fname) {
                        $foundFilter = false;
                        //first try builtins
                        if ($this->builtins->hasFilter($fname) &&
                            ($this->builtins->single($fname)!==null) &&
                            (!$this->customFilters->hasFilter($fname))) { //custom filters override builtins
                                $fp->add($this->builtins->single($fname));
                                $foundFilter = true;
                        }
                        //then check custom
                        if ($this->customFilters->hasFilter($fname) && ($this->customFilters->single($fname)!==null)) {
                            $fp->add($this->customFilters->single($fname));
                            $foundFilter = true;
                        }

                        if (!$foundFilter)
                            throw new \Exception('Filter not found: "'.$fname.'".');
                    }

                    $value = $this->getVariable($varName);
                    $value = $fp->execute($value);
                    $result = preg_replace("/". preg_quote($toReplace)."/", $value, $result, 1);
                }
            }
        }

        return $result;
    }

}
