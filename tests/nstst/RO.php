<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class RO
{
    use \axy\magic\ReadOnly;
    use \axy\magic\Named;

    protected $magicName = 'CRO';

    public $v;

    public function __get($key)
    {
        return 'k_'.$key;
    }
}
