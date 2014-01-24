<?php
/**
 * @package axy\magic
 */

namespace axy\magic;

use axy\magic\errors\ContainerReadOnly;
use axy\magic\errors\FieldNotExist;

/**
 * The wrapper for an array
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class ArrayWrapper implements \ArrayAccess, \Countable, \IteratorAggregate
{
    use Named;

    /**
     * Constructor
     *
     * @param array $source [optional]
     *        the source array (by default - empty)
     * @param boolean $readonly [optional]
     *        the readonly flag (by default - as defined in this class)
     * @param boolean $errprop [optional]
     *        the error NotFound flag (by default - as defined in this class)
     * @throws \axy\magic\errors\FieldNotExist
     *         the source contains an unknown field (for a rigid structure)
     */
    public function __construct(array $source = null, $readonly = null, $errprop = null)
    {
        if ($source) {
            if ($this->source) {
                if ($this->rigidly) {
                    $diff = \array_diff_key($source, $this->source);
                    if (!empty($diff)) {
                        \reset($diff);
                        throw new FieldNotExist(\key($diff), $this);
                    }
                }
                $this->source = \array_replace($this->source, $source);
            } else {
                $this->source = $source;
            }
        } elseif ($this->source === null) {
            $this->source = [];
        }
        if (\is_bool($readonly)) {
            $this->readonly = $readonly;
        }
        if (\is_bool($errprop)) {
            $this->errprop = $errprop;
        }
    }

    /**
     * Get the source array
     *
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Switch the object in read-only mode
     */
    public function toReadonly()
    {
        $this->readonly = true;
    }

    /**
     * Checks if the object in read-only mode
     *
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function __get($key)
    {
        return $this->get($this->convertKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($key)
    {
        return $this->exists($this->convertKey($key));
    }

    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\ContainerReadOnly
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function __set($key, $value)
    {
        return $this->set($this->convertKey($key), $value);
    }

    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\ContainerReadOnly
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function __unset($key)
    {
        return $this->remove($this->convertKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->exists($this->convertIndex($offset));
    }

    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function offsetGet($offset)
    {
        return $this->get($this->convertIndex($offset));
    }

    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\ContainerReadOnly
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($this->convertIndex($offset), $value);
    }

    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\ContainerReadOnly
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function offsetUnset($offset)
    {
        return $this->remove($this->convertIndex($offset));
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return \count($this->source);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->source);
    }

    /**
     * Converts an index of the object (ArrayAccess) to an index of the source array
     *
     * @param string $index
     * @return string
     */
    protected function convertIndex($index)
    {
        return $index;
    }

    /**
     * Converts a key of an object property to an index of the source array
     *
     * @param string $key
     * @return string
     */
    protected function convertKey($key)
    {
        return $key;
    }

    /**
     * Returns an item from the source
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function get($key)
    {
        if (!\array_key_exists($key, $this->source)) {
            if ($this->errprop) {
                throw new FieldNotExist($key, $this);
            }
            return null;
        }
        return $this->source[$key];
    }

    /**
     * Check if an item is exists
     *
     * @param string $key
     * @return boolean
     */
    protected function exists($key)
    {
        return \array_key_exists($key, $this->source);
    }

    /**
     * Set an item value
     *
     * @param string $key
     * @param mixed $value
     * @throws \axy\magic\errors\ContainerReadOnly
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function set($key, $value)
    {
        if ($this->readonly) {
            throw new ContainerReadOnly($this);
        }
        if ($this->rigidly && (!\array_key_exists($key, $this->source))) {
            throw new FieldNotExist($key, $this);
        }
        $this->source[$key] = $value;
    }

    /**
     * Removes an item from the source array
     *
     * @param string $key
     * @throws \axy\magic\errors\ContainerReadOnly
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function remove($key)
    {
        if ($this->readonly) {
            throw new ContainerReadOnly($this);
        }
        if ($this->errprop) {
            if (!\array_key_exists($key, $this->source)) {
                throw new FieldNotExist($key, $this);
            }
        }
        if ($this->rigidly) {
            throw new FieldNotExist($key, $this);
        }
        unset($this->source[$key]);
    }

    /**
     * The source array
     *
     * @var array
     */
    protected $source;

    /**
     * The read-only flag
     *
     * @var boolean
     */
    protected $readonly = false;

    /**
     * Throw exception if property not found (by default - returns NULL)
     *
     * @var boolean
     */
    protected $errprop = false;

    /**
     * Rigid structure
     *
     * @var boolean
     */
    protected $rigidly = false;
}
