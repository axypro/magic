<?php
/**
 * @package axy\magic
 */

namespace axy\magic;

/**
 * The named container
 *
 * By default, the name of container equals of it class name.
 * You can override a static variable "magicName" or method getMagicName().
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
trait Named
{
    /**
     * Get the name of the container
     *
     * @return string
     */
    protected function getMagicName()
    {
        if (!empty(static::$magicName)) {
            return static::$magicName;
        }
        return \get_class($this);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getMagicName();
    }
}
