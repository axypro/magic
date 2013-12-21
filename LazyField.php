<?php
/**
 * @package axy\magic
 */

namespace axy\magic;

use axy\magic\errors\FieldNotExist;

/**
 * The container with lazy property creation
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
trait LazyField
{
    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @return mixed
     * @throws \axy\magic\errors\FieldNotExists
     */
    public function __get($key)
    {
        if (!\array_key_exists($key, $this->magicFieldsStorage)) {
            $this->magicFieldsStorage[$key] = $this->magicCreateField($key);
        }
        return $this->magicFieldsStorage[$key];
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        if (!isset($this->magicFieldsExists[$key])) {
            $this->magicFieldsExists[$key] = $this->magicExistsField($key);
        }
        return $this->magicFieldsExists[$key];
    }

    /**
     * Creating field value by key
     *
     * @param string $key
     *        a key of the field
     * @return mixed
     *         a value of the field
     * @throws \axy\magic\errors\FieldNotExists
     *         this key is not exists
     */
    protected function magicCreateField($key)
    {
        $this->magicErrorFieldNotFound($key);
    }

    /**
     * Check if magic field is exists
     *
     * @param string $key
     * @return boolean
     */
    protected function magicExistsField($key)
    {
        return false;
    }

    /**
     * Report error (field not found)
     *
     * @param string $key
     * @throws \axy\magic\errors\FieldNotExists
     */
    protected function magicErrorFieldNotFound($key)
    {
        throw new FieldNotExist($key, $this);
    }

    /**
     * The storage for created fields
     *
     * @var array
     */
    protected $magicFieldsStorage = [];

    /**
     * The cahce for isset()
     *
     * @var boolean
     */
    protected $magicFieldsExists = [];
}
