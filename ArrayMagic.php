<?php
/**
 * @package axy\magic
 */

namespace axy\magic;

/**
 * ArrayAccess-requests are forwarded to the magic methods
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
trait ArrayMagic
{
    /**
     * Convert an array index to a magic key
     *
     * @param string $index
     * @return string
     */
    protected function magicConvertIndexToKey($index)
    {
        return $index;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->__isset($this->magicConvertIndexToKey($offset));
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->__get($this->magicConvertIndexToKey($offset));
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        return $this->__set($this->magicConvertIndexToKey($offset), $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        return $this->__unset($this->magicConvertIndexToKey($offset));
    }
}
