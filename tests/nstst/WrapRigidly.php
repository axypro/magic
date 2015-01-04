<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

use axy\magic\ArrayWrapper;

class WrapRigidly extends ArrayWrapper
{
    /**
     * {@inheritdoc}
     */
    protected $rigidly = true;

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
