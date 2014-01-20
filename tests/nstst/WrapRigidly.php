<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class WrapRigidly extends \axy\magic\ArrayWrapper
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
