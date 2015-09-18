<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\tests\tst\lazyContainer;

use axy\magic\LazyContainer;

class Merge extends LazyContainer
{
    protected $props = [
        'one' => 1,
        'two' => 2,
    ];
}
