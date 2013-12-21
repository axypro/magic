<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class NamedParent
{
    use \axy\magic\Named;

    public function getName()
    {
        return $this->getMagicName();
    }
}
