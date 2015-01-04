<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

use axy\magic\ArrayMagic;

class AAMagic implements \ArrayAccess
{
    use ArrayMagic;

    /**
     * Construct
     *
     * @param array $vars
     */
    public function __construct(array $vars = array())
    {
        $this->vars = $vars;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    public function __get($key)
    {
        return isset($this->vars[$key]) ? $this->vars[$key] : null;
    }

    public function __set($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->vars[$key]);
    }

    public function __unset($key)
    {
        unset($this->vars[$key]);
    }

    /**
     * @var array
     */
    private $vars;
}
