<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

use \axy\magic\ArrayWrapper;

class Wrap extends ArrayWrapper
{
    /**
     * {@inheritdoc}
     */
    protected function convertIndex($index)
    {
        return str_replace('-', ' ', $index);
    }

    /**
     * {@inheritdoc}
     */
    protected function convertKey($key)
    {
        return str_replace('_', ' ', $key);
    }

    /**
     * {@inheritdoc}
     */
    protected $source = [
        'one item' => 'first',
        'two item' => 'second',
    ];
}
