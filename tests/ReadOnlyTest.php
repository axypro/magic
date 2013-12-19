<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\tests\nstst\RO;

/**
 * @coversDefaultClass axy\magic\ReadOnly
 */
class ReadOnlyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__set
     * @expectedException \axy\magic\errors\ContainerReadOnly
     * @expectedExceptionMessage axy\magic\tests\nstst\RO is read-only
     */
    public function testSet()
    {
        $instance = new RO();
        $instance->x = 10;
    }

    /**
     * @covers ::__unset
     * @expectedException \axy\magic\errors\ContainerReadOnly
     * @expectedExceptionMessage axy\magic\tests\nstst\RO is read-only
     */
    public function testUnset()
    {
        $instance = new RO();
        unset($instance->x);
    }

    /**
     * @covers ::__set
     */
    public function testRealSet()
    {
        $instance = new RO();
        $instance->v = 10;
        $this->assertSame(10, $instance->v);
    }

    /**
     * @covers ::__get
     */
    public function testMagicGet()
    {
        $instance = new RO();
        $this->assertSame('k_var', $instance->var);
    }
}
