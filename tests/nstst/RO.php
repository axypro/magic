<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

use \axy\magic\ReadOnly;
use \axy\magic\Named;

class RO
{
    use ReadOnly;
    use Named;

    protected $magicName = 'CRO';

    public $v;

    public function __get($key)
    {
        return 'k_'.$key;
    }
}
