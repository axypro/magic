<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic;

use axy\magic\errors\ContainerReadOnly;

/**
 * The read-only container
 *
 * @link https://github.com/axypro/magic/blob/master/doc/ReadOnly.md documentation
 */
trait ReadOnly
{
    /**
     * Magic set is forbidden
     *
     * @param string $key
     * @param mixed $value
     * @throws \axy\magic\errors\ContainerReadOnly
     */
    public function __set($key, $value)
    {
        throw new ContainerReadOnly($this);
    }

    /**
     * Magic unset is forbidden
     *
     * @param string $key
     * @throws \axy\magic\errors\ContainerReadOnly
     */
    public function __unset($key)
    {
        throw new ContainerReadOnly($this);
    }
}
