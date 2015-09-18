<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\tests;

use axy\magic\LazyContainer;
use axy\magic\tests\tst\lazyContainer\Merge;
use axy\magic\tests\tst\lazyContainer\LContainer;

/**
 * coversDefaultClass axy\magic\LazyContainer
 */
class LazyContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructSet()
    {
        $container = new LazyContainer(['x' => 1, 'y' => 2]);
        $this->assertSame(1, $container->x);
        $this->assertSame(2, $container->y);
        $this->assertTrue(isset($container->x));
        $this->assertTrue(isset($container->y));
        $this->assertFalse(isset($container->z));
        $this->setExpectedException('axy\magic\errors\FieldNotExist');
        return $container->z;
    }

    public function testAA()
    {
        $container = new LazyContainer(['x' => 1, 'y' => 2]);
        $this->assertSame(1, $container['x']);
        $this->assertSame(2, $container['y']);
        $this->assertTrue(isset($container['x']));
        $this->assertTrue(isset($container['y']));
        $this->assertFalse(isset($container['z']));
        $this->setExpectedException('axy\errors\FieldNotExist');
        return $container['z'];
    }

    public function testMerge()
    {
        $container = new Merge(['two' => 4, 'three' => 3]);
        $this->assertSame(1, $container->one);
        $this->assertSame(4, $container->two);
        $this->assertSame(3, $container->three);
        $this->assertTrue(isset($container->one));
        $this->assertTrue(isset($container->two));
        $this->assertTrue(isset($container->three));
        $this->assertFalse(isset($container->four));
        $this->setExpectedException('axy\errors\FieldNotExist');
        return $container->four;
    }

    public function testContainer()
    {
        $container = new LContainer();
        $this->assertTrue(isset($container->one));
        $this->assertTrue(isset($container->two));
        $this->assertTrue(isset($container->twoTwo));
        $this->assertTrue(isset($container->three));
        $this->assertFalse(isset($container->four));
        $one = $container->one;
        $two = $container->two;
        $twoTwo = $container->twoTwo;
        $three = $container->three;
        $this->assertSame(1, $one);
        $this->assertSame(2, $two->tag);
        $this->assertSame(2, $twoTwo->tag);
        $this->assertSame(3, $three->tag);
        $this->assertSame($two, $container->two);
        $this->assertNotSame($two, $twoTwo);
        $this->assertSame($three, $container->three);
        $this->setExpectedException('axy\errors\FieldNotExist');
        return $container->four;
    }

    /**
     * @expectedException \axy\magic\errors\ContainerReadOnly
     */
    public function testReadOnly()
    {
        $container = new LContainer();
        $container->one = 2;
    }
}
