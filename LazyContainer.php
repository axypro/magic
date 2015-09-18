<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic;

use axy\magic\errors\FieldNotExist;

/**
 * Container with fixed set of lazy properties
 *
 * @link https://github.com/axypro/magic/blob/master/doc/LazyContainer.md documentation
 */
class LazyContainer implements \ArrayAccess
{
    use ArrayMagic;
    use ReadOnly;

    /**
     * The constructor
     *
     * @param array $props [optional]
     */
    public function __construct(array $props = null)
    {
        if (!empty($props)) {
            if (empty($this->props)) {
                $this->props = $props;
            } else {
                $this->props = array_merge($this->props, $props);
            }
        }
    }

    /**
     * Magic get
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function __get($key)
    {
        if (!array_key_exists($key, $this->props)) {
            $m = $key.'PropCreate';
            if (method_exists($this, $m)) {
                $this->props[$key] = $this->$m();
            } else {
                $this->props[$key] = $this->propCreate($key);
            }
        }
        return $this->props[$key];
    }

    /**
     * Magic isset
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        if (!array_key_exists($key, $this->props)) {
            try {
                $this->__get($key);
            } catch (FieldNotExist $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * Creates a property by the key
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function propCreate($key)
    {
        throw new FieldNotExist($key, $this);
    }

    /**
     * Already created properties
     *
     * @var array
     */
    protected $props = [];
}
