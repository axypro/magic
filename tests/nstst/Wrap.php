<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class Wrap extends \axy\magic\ArrayWrapper
{
    /**
     * {@inheritdoc}
     */
    protected function convertIndex($index)
    {
        return \str_replace('-', ' ', $index);
    }

    /**
     * {@inheritdoc}
     */
    protected function convertKey($key)
    {
        return \str_replace('_', ' ', $key);
    }

    /**
     * {@inheritdoc}
     */
    protected $source = [
        'one item' => 'first',
        'two item' => 'second',
    ];
}
