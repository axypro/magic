<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic;

use axy\magic\errors\FieldNotExist;
use axy\callbacks\Callback;

/**
 * The container with lazy fields
 *
 * @link https://github.com/axypro/magic/blob/master/doc/LazyField.md documentation
 */
trait LazyField
{
    /**
     * {@inheritdoc}
     * @throws \axy\magic\errors\FieldNotExist
     */
    public function __get($key)
    {
        return $this->magicGet($key);
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($key)
    {
        return $this->magicIsset($key);
    }

    /**
     * Returns a magic property
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function magicGet($key)
    {
        if (!$this->magicInited) {
            $this->magicInit();
        }
        $fields = &$this->magicFields['fields'];
        if (!array_key_exists($key, $fields)) {
            if (isset($this->magicFields['loaders'][$key])) {
                $loader = $this->magicFields['loaders'][$key];
                if ((is_string($loader)) && (substr($loader, 0, 2) == '::')) {
                    $loader = substr($loader, 2);
                    $fields[$key] = $this->$loader($key);
                } else {
                    $fields[$key] = Callback::call($loader, [$key]);
                }
            } else {
                $fields[$key] = $this->magicCreateField($key);
            }
        }
        return $fields[$key];
    }

    /**
     * Checks if a magic property is exists
     *
     * @param string $key
     * @return boolean
     */
    protected function magicIsset($key)
    {
        if (!$this->magicInited) {
            $this->magicInit();
        }
        $exists = &$this->magicFields['exists'];
        if (!array_key_exists($key, $exists)) {
            if (array_key_exists($key, $this->magicFields['fields'])) {
                $exists[$key] = true;
            } elseif (isset($this->magicFields['loaders'][$key])) {
                $exists[$key] = true;
            } else {
                $exists[$key] = $this->magicExistsField($key);
            }
        }
        return $exists[$key];
    }

    /**
     * Creates a lazy field
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function magicCreateField($key)
    {
        return $this->magicErrorFieldNotExist($key);
    }

    /**
     * Checks is a lazy field is exists
     *
     * @param string $key
     * @return boolean
     */
    protected function magicExistsField($key)
    {
        return false;
    }

    /**
     * Signals an error
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExist
     */
    protected function magicErrorFieldNotExist($key)
    {
        throw new FieldNotExist($key, $this);
    }

    /**
     * Returns the defaults parameters
     *
     * @return array
     */
    protected function magicGetDefaults()
    {
        if (property_exists($this, 'magicDefaults')) {
            /** @noinspection PhpUndefinedFieldInspection */
            if (is_array($this->magicDefaults)) {
                /** @noinspection PhpUndefinedFieldInspection */
                return $this->magicDefaults;
            }
        }
        return [];
    }

    /**
     * Initializations of magic fields
     */
    protected function magicInit()
    {
        if (!$this->magicInited) {
            $this->magicFields = array_replace($this->magicFields, $this->magicGetDefaults());
            $this->magicInited = true;
        }
    }

    /**
     * The list of loaded fields and other parameters
     *
     * @var array
     */
    protected $magicFields = [
        'fields' => [],
        'exists' => [],
        'loaders' => [],
    ];

    // Defaults parameters (for override)
    // protected $magicDefaults

    /**
     * The flag that magic fields is initialized
     *
     * @var boolean
     */
    protected $magicInited = false;
}
