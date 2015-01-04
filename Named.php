<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic;

/**
 * The named container
 *
 * By default, the name of container equals to its class name.
 * You can override the static variable "magicName" or method magicGetName().
 */
trait Named
{
    /**
     * Returns the name of the container
     *
     * @return string
     */
    protected function magicGetName()
    {
        if (property_exists($this, 'magicName') && (!empty($this->magicName))) {
            return $this->magicName;
        }
        return get_class($this);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->magicGetName();
    }
}
