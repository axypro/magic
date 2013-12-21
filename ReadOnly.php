<?php
/**
 * @package axy\magic
 */

namespace axy\magic;

use axy\magic\errors\ContainerReadOnly;

/**
 * Read-only container
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
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
        $name = \method_exists($this, 'getMagicName') ? $this->getMagicName() : \get_class($this);
        throw new ContainerReadOnly($name);
    }

    /**
     * Magic unset is forbidden
     *
     * @param string $key
     * @throws \axy\magic\errors\ContainerReadOnly
     */
    public function __unset($key)
    {
        $name = \method_exists($this, 'getMagicName') ? $this->getMagicName() : \get_class($this);
        throw new ContainerReadOnly($name);
    }
}
