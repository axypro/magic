<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\tests\tst\NamedParent;
use axy\magic\tests\tst\NamedChild;
use axy\magic\tests\tst\NamedChildOver;

/**
 * coversDefaultClass axy\magic\Named
 */
class NamedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::magicGetName
     */
    public function testDefault()
    {
        $instance = new NamedParent();
        $this->assertSame('axy\magic\tests\tst\NamedParent', $instance->getName());
        $this->assertSame('axy\magic\tests\tst\NamedParent', (string)$instance);
    }

    /**
     * covers ::magicGetName
     */
    public function testProperty()
    {
        $instance = new NamedChild();
        $this->assertSame('Child', $instance->getName());
        $this->assertSame('Child', (string)$instance);
    }

    /**
     * covers ::magicGetName
     */
    public function testMethod()
    {
        $instance = new NamedChildOver();
        $this->assertSame('ChildOver', $instance->getName());
        $this->assertSame('Override', (string)$instance);
    }
}
