<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\tests\tst\lazy\LF;
use axy\magic\tests\tst\lazy\LFChild;

/**
 * coversDefaultClass axy\magic\LazyField
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class LazyFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testExternal()
    {
        $lazy = new LF();
        $this->assertTrue(isset($lazy->click));
        $this->assertSame(1, $lazy->click);
        $this->assertSame(2, $lazy->click);
    }

    public function testStatic()
    {
        $lazy = new LF();
        $this->assertTrue(isset($lazy->static_f));
        $this->assertSame('value of static', $lazy->static_f);
        $this->assertSame('value of static', $lazy->static_f);
    }

    public function testLoaders()
    {
        LF::$calls = [];
        $lazy = new LF();
        $this->assertTrue(isset($lazy->one));
        $this->assertTrue(isset($lazy->two));
        $this->assertTrue(isset($lazy->one));
        $this->assertTrue(isset($lazy->two));
        $this->assertEquals([1, 2, 'one'], $lazy->one);
        $this->assertSame('ktwo', $lazy->two);
        $this->assertEquals([1, 2, 'one'], $lazy->one);
        $this->assertSame('ktwo', $lazy->two);
        $this->assertEquals(['getSelfArgs:one', 'createTwo:two'], LF::$calls);
    }

    public function testCreate()
    {
        LF::$calls = [];
        $lazy = new LF();
        $this->assertTrue(isset($lazy->first));
        $this->assertTrue(isset($lazy->second));
        $this->assertTrue(isset($lazy->first));
        $this->assertTrue(isset($lazy->second));
        $this->assertSame('Content of first.txt', $lazy->first);
        $this->assertSame('Content of second.txt', $lazy->second);
        $this->assertSame('Content of first.txt', $lazy->first);
        $this->assertSame('Content of second.txt', $lazy->second);
        $this->assertEquals(['isset:second', 'load:first', 'load:second'], LF::$calls);
    }

    public function testUnknown()
    {
        LF::$calls = [];
        $lazy = new LF();
        $this->assertFalse(isset($lazy->unk));
        $this->assertFalse(isset($lazy->unkn));
        $this->assertFalse(isset($lazy->unk));
        $this->assertFalse(isset($lazy->unkn));
        $this->assertEquals(['isset:unk'], LF::$calls);
        $msg = 'Field "unk" is not exist in "TestLF"';
        $this->setExpectedException('axy\magic\errors\FieldNotExist', $msg);
        return $lazy->unk;
    }

    public function testEdit()
    {
        $lazy = new LF();
        $lazy->setStatic('new value');
        $this->assertSame('new value', $lazy->static_f);
    }

    public function testOverGet()
    {
        $lazy = new LFChild();
        $this->assertTrue(isset($lazy->child));
        $this->assertTrue(isset($lazy->click));
        $this->assertSame('value child', $lazy->child);
        $this->assertSame(1, $lazy->click);
    }

    public function testOverStatic()
    {
        $lazy = new LFChild();
        $this->assertTrue(isset($lazy->static_f));
        $this->assertTrue(isset($lazy->new_static));
        $this->assertSame('value of static', $lazy->static_f);
        $this->assertSame('nsv', $lazy->new_static);
    }

    public function testOverLoaders()
    {
        $lazy = new LFChild();
        $this->assertTrue(isset($lazy->one));
        $this->assertFalse(isset($lazy->two));
        $this->assertTrue(isset($lazy->three));
        $this->assertEquals([1, 2, 'one'], $lazy->one);
        $this->assertSame(null, $lazy->two);
        $this->assertSame('v three', $lazy->three);
    }

    public function testOverCreate()
    {
        $lazy = new LFChild();
        $this->assertTrue(isset($lazy->first));
        $this->assertTrue(isset($lazy->qwe));
        $this->assertFalse(isset($lazy->unk));
        $this->assertSame('Content of first.txt', $lazy->first);
        $this->assertSame('rty', $lazy->qwe);
        $this->assertSame(null, $lazy->unk);
    }

    /**
     * @expectedException \axy\magic\errors\ContainerReadOnly
     */
    public function testReadOnly()
    {
        $lazy = new LFChild();
        $lazy->one = 1;
    }

    public function testArrayAccess()
    {
        $lazy = new LFChild();
        $this->assertTrue(isset($lazy['first']));
        $this->assertSame('Content of first.txt', $lazy['first']);
    }
}
