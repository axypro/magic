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
     * Returns the name of the container
     *
     * @return string
     */
    protected function magicGetName()
    {
        if ((\property_exists($this, 'magicName')) && (!empty($this->magicName))) {
            return $this->magicName;
        }
        return \get_class($this);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->magicGetName();
    }
}
