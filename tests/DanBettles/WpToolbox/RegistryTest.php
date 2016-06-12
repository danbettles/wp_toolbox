<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Tests\DanBettles\WpToolbox\Registry;

use DanBettles\WpToolbox\Registry;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testGetinstanceReturnsTheSingleInstanceOfTheClass()
    {
        $registry = Registry::getInstance();

        $this->assertInstanceOf('DanBettles\WpToolbox\Registry', $registry);
        $this->assertSame($registry, Registry::getInstance());
    }

    public function testIsEmptyByDefault()
    {
        $registry = Registry::getInstance();

        $this->assertEquals([], $registry->toArray());
    }

    public function testGetReturnsAValueAddedUsingSet()
    {
        $origRegistry = Registry::getInstance();

        $registry = new Registry();
        Registry::setInstance($registry);

        $this->assertSame($registry, Registry::getInstance());
        $this->assertNotSame($origRegistry, Registry::getInstance());

        $something = Registry::getInstance()->set('foo', 'bar');

        $this->assertSame('bar', Registry::getInstance()->get('foo'));
        $this->assertSame(Registry::getInstance(), $something);

        Registry::setInstance($origRegistry);

        $this->assertSame($origRegistry, Registry::getInstance());
    }
}
