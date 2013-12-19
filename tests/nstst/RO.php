<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class RO
{
    use \axy\magic\ReadOnly;

    protected $magicName = 'RO';

    public $v;

    public function __get($key)
    {
        return 'k_'.$key;
    }
}
