<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests;

use axy\magic\tests\nstst\NamedParent;
use axy\magic\tests\nstst\NamedChild;
use axy\magic\tests\nstst\NamedChildOver;

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
        $this->assertSame('axy\magic\tests\nstst\NamedParent', $instance->getName());
        $this->assertSame('axy\magic\tests\nstst\NamedParent', (string)$instance);
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
