<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\tests\nstst\LFOver;

/**
 * @coversDefaultClass axy\magic\LazyField
 */
class LazyFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::magicCreateField
     * @covers ::magicExistsField
     */
    public function testLazy()
    {
        $lazy = new LFOver();
        $this->assertTrue(isset($lazy->over_field));
        $this->assertTrue(isset($lazy->prop_10));
        $this->assertTrue(isset($lazy->prop_10));
        $this->assertTrue(isset($lazy->prop_110));
        $this->assertFalse(isset($lazy->prop_10x));
        $this->assertFalse(isset($lazy->unknown));
        $this->assertSame('over_value', $lazy->over_field);
        $this->assertSame(20, $lazy->prop_10);
        $this->assertSame(220, $lazy->prop_110);
        $this->assertSame(20, $lazy->prop_10);
        $this->assertSame(null, $lazy->prop_0);
        $this->assertSame(null, $lazy->prop_0);
        $this->assertTrue(isset($lazy->prop_10));
        $this->assertTrue(isset($lazy->prop_200));
        $this->assertEquals(['prop_10', 'prop_110', 'prop_0'], $lazy->requests);
        $this->assertEquals(['prop_10', 'prop_110', 'prop_200'], $lazy->issetRequests);
        $msg = 'Field "unknown" is not exist in "TestLF"';
        $this->setExpectedException('\axy\magic\errors\FieldNotExist', $msg);
        return $lazy->unknown;
    }

    public function testOtherTraits()
    {
        $lazy = new LFOver();
        $this->assertTrue(isset($lazy['over_field']));
        $this->assertTrue(isset($lazy['prop_10']));
        $this->assertFalse(isset($lazy['prop_10x']));
        $this->assertSame(20, $lazy['prop_10']);
        $msg = 'TestLF is read-only';
        $this->setExpectedException('\axy\magic\errors\ContainerReadOnly', $msg);
        $lazy['prop_10'] = 10;
    }
}
