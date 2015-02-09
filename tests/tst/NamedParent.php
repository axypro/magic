<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\tst;

use axy\magic\Named;

class NamedParent
{
    use Named;

    public function getName()
    {
        return $this->magicGetName();
    }
}
