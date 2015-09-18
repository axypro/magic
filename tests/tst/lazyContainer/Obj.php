<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\tests\tst\lazyContainer;

class Obj
{
    public $tag;

    public function __construct($tag)
    {
        $this->tag = $tag;
    }
}
