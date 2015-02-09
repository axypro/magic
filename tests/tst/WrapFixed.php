<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\tst;

use axy\magic\ArrayWrapper;

class WrapFixed extends ArrayWrapper
{
    /**
     * {@inheritdoc}
     */
    protected $fixed = true;

    /**
     * {@inheritdoc}
     */
    protected $source = [
        'one' => 'first',
        'two' => 'second',
    ];

    /**
     * {@inheritdoc}
     */
    protected $magicName = 'Wrap';
}
