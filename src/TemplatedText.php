<?php

namespace Permafrost;

class TemplatedText extends Template
{

    public function __construct()
    {
        //
    }

    public function process()
    {
        $result = $this->template;
        foreach($this->replacements as $var => $value) {
            if (is_callable($value)) {
                $value = $value($var);
            }
            if ($value !== false)
                $result = preg_replace('/{{'.preg_quote($var).'}}/', $value, $result);
        }
        return $result;
    }

}
