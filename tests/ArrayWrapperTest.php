<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\ArrayWrapper;
use axy\magic\tests\nstst\Wrap;
use axy\magic\tests\nstst\WrapRigidly;

/**
 * @coversDefaultClass axy\magic\ArrayWrapper
 */
class ArrayWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getSource
     * @covers ::__construct
     */
    public function testGetSource()
    {
        $wrapper1 = new ArrayWrapper();
        $this->assertEquals([], $wrapper1->getSource());
        $wrapper2 = new ArrayWrapper(['x' => 1, 'y' => 2]);
        $this->assertEquals(['x' => 1, 'y' => 2], $wrapper2->getSource());
    }

    /**
     * @covers ::__get()
     * @covers ::__isset()
     * @covers ::__set()
     * @covers ::__unset()
     */
    public function testMagic()
    {
        $wrapper = new ArrayWrapper(['x' => 1, 'y' => 2]);
        $this->assertTrue(isset($wrapper->x));
        $this->assertFalse(isset($wrapper->z));
        $wrapper->z = null;
        $this->assertTrue(isset($wrapper->z));
        $wrapper->a = 'this is a';
        $wrapper->x = 10;
        $this->assertSame('this is a', $wrapper->a);
        $this->assertSame(10, $wrapper->x);
        unset($wrapper->x);
        $this->assertFalse(isset($wrapper->x));
        $this->assertSame(null, $wrapper->x);
        $this->assertSame(2, $wrapper->y);
        $this->assertSame(null, $wrapper->z);
        $this->assertEquals(['a' => 'this is a', 'y' => 2, 'z' => null], $wrapper->getSource());
    }

    /**
     * @covers ::offsetExists()
     * @covers ::offsetGet()
     * @covers ::offsetSet()
     * @covers ::offsetUnset()
     */
    public function testArrayAccess()
    {
        $wrapper = new ArrayWrapper(['x' => 1, 'y' => 2]);
        $this->assertTrue(isset($wrapper['x']));
        $this->assertFalse(isset($wrapper['z']));
        $wrapper['z'] = null;
        $this->assertTrue(isset($wrapper['z']));
        $wrapper['a'] = 'this is a';
        $wrapper['x'] = 10;
        $this->assertSame('this is a', $wrapper['a']);
        $this->assertSame(10, $wrapper['x']);
        unset($wrapper['x']);
        $this->assertFalse(isset($wrapper['x']));
        $this->assertSame(null, $wrapper['x']);
        $this->assertSame(2, $wrapper['y']);
        $this->assertSame(null, $wrapper['z']);
        $this->assertEquals(['a' => 'this is a', 'y' => 2, 'z' => null], $wrapper->getSource());
    }

    /**
     * @covers ::count
     */
    public function testCount()
    {
        $wrapper = new ArrayWrapper(['x' => 'this is X']);
        $wrapper->y = 'this is Y';
        $this->assertCount(2, $wrapper);
    }

    /**
     * @covers ::getIterator
     */
    public function testTraversable()
    {
        $wrapper = new ArrayWrapper(['x' => 'this is X']);
        $wrapper->y = 'this is Y';
        $expected = [
            'x' => 'this is X',
            'y' => 'this is Y',
        ];
        $this->assertEquals($expected, \iterator_to_array($wrapper));
    }

    /**
     * @covers ::convertIndex
     * @covers ::convertKey
     */
    public function testConvertIndexKey()
    {
        $wrapper = new Wrap();
        $wrapper->qwe_rty = 'iop';
        $this->assertTrue(isset($wrapper->qwe_rty));
        $this->assertTrue(isset($wrapper['qwe-rty']));
        $this->assertSame('iop', $wrapper['qwe-rty']);
        $wrapper['qwe-rty'] = 111;
        $this->assertSame(111, $wrapper->qwe_rty);
        $source = $wrapper->getSource();
        $this->assertArrayHasKey('qwe rty', $source);
        $this->assertSame(111, $source['qwe rty']);
    }

    public function testDefault()
    {
        $wrapper = new Wrap(['two item' => 'new value', 'qq qq' => 'ww ww']);
        $wrapper->qq_qq = 10;
        $this->assertSame('first', $wrapper->one_item);
        $this->assertSame('new value', $wrapper->two_item);
        $this->assertSame(10, $wrapper->qq_qq);
        $this->assertCount(3, $wrapper);
        $expected = [
            'one item' => 'first',
            'two item' => 'new value',
            'qq qq' => 10,
        ];
        $this->assertEquals($expected, \iterator_to_array($wrapper));
    }

    /**
     * @covers ::__construct
     * @covers ::toReadOnly
     * @covers ::isReadOnly
     */
    public function testReadOnly()
    {
        $wrapper1 = new ArrayWrapper();
        $this->assertFalse($wrapper1->isReadonly());
        $wrapper1->toReadonly();
        $this->assertTrue($wrapper1->isReadonly());
        $wrapper2 = new ArrayWrapper(null, true);
        $this->assertTrue($wrapper2->isReadonly());
        $this->setExpectedException('axy\magic\errors\ContainerReadOnly');
        $wrapper2->x = 10;
    }

    public function testNotFound()
    {
        $wrapper = new Wrap(['a' => 10], null, true);
        $this->assertSame('first', $wrapper->one_item);
        $this->assertSame(10, $wrapper->a);
        $this->setExpectedException('axy\magic\errors\FieldNotExist');
        return $wrapper->unk;
    }

    public function testRigidlySet()
    {
        $wrapper = new WrapRigidly(['one' => 'One']);
        $wrapper->one = 1;
        $wrapper->two = 2;
        $this->setExpectedException('axy\magic\errors\FieldNotExist');
        $wrapper->three = 3;
    }

    /**
     * @expectedException axy\magic\errors\FieldNotExist
     * @expectedExceptionMessage Field "three" is not exist in "Wrap"
     */
    public function testRigidlyConstruct()
    {
        return new WrapRigidly(['one' => 'One', 'three' => 3]);
    }
}
