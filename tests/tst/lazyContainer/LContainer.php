<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\tests\tst\lazyContainer;

use axy\magic\LazyContainer;

class LContainer extends LazyContainer
{
    public function __construct()
    {
        parent::__construct(null);
    }

    public function onePropCreate()
    {
        return new Obj(1);
    }

    public function twoPropCreate()
    {
        return new Obj(2);
    }

    public function twoTwoPropCreate()
    {
        return new Obj(2);
    }

    public function propCreate($key)
    {
        if ($key === 'three') {
            return new Obj(3);
        }
        return parent::propCreate($key);
    }

    protected $props = [
        'one' => 1,
    ];
}
