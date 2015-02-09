<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\tst;

class NamedChildOver extends NamedParent
{
    /**
     * @return string
     */
    protected function magicGetName()
    {
        return 'ChildOver';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Override';
    }
}
