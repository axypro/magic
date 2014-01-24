<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\tests\nstst\AAMagic;
use axy\magic\tests\nstst\AAMagicConvert;
use axy\magic\tests\nstst\AAMagicRO;

/**
 * @coversDefaultClass axy\magic\ArrayMagic
 */
class ArrayMagicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::offsetExists
     * @covers ::offsetGet
     * @covers ::offsetSet
     * @covers ::offsetUnset
     */
    public function testAA()
    {
        $a = new AAMagic(['x' => 1, 'y' => 2]);
        $this->assertSame(1, $a['x']);
        $this->assertSame(null, $a['z']);
        $this->assertTrue(isset($a['x']));
        $this->assertFalse(isset($a['z']));
        unset($a['x']);
        $a['z'] = 10;
        $this->assertEquals(['y' => 2, 'z' => 10], $a->getVars());
    }

    /**
     * @covers ::magicConvertIndexToKey
     */
    public function testConvertKey()
    {
        $a = new AAMagicConvert(['one_two' => 1, 'y' => 2]);
        $this->assertSame(1, $a['one-two']);
        $this->assertSame(1, $a['one_two']);
        $this->assertTrue(isset($a['one-two']));
        $this->assertTrue(isset($a['one_two']));
        $this->assertFalse(isset($a['unk']));
        unset($a['one-two']);
        $a['three-four'] = 10;
        $this->assertEquals(['three_four' => 10, 'y' => 2], $a->getVars());
    }

    public function testRO()
    {
        $a = new AAMagicRO(['x' => 1]);
        $this->assertSame(1, $a['x']);
        $this->assertSame(null, $a['z']);
        $this->setExpectedException('axy\magic\errors\ContainerReadOnly');
        $a['x'] = 5;
    }
}
