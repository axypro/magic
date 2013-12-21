<?php
/**
 * @package axy\magic
 */

namespace axy\magic;

/**
 * ArrayAccess-requests are forwarded to magic methods
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
trait ArrayMagic
{
    /**
     * Covert an array index to a magic key
     *
     * @param string $key
     * @return string
     */
    protected function magicConvertIndexToKey($key)
    {
        return $key;
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
