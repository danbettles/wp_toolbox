<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Tests\DanBettles\WpToolbox\Collection;

use DanBettles\WpToolbox\Collection;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $collection = new Collection(['Buddha', 'Dharma', 'Sangha']);

        $this->assertEquals(['Buddha', 'Dharma', 'Sangha'], $collection->toArray());
    }

    public static function providesValuesByKey()
    {
        return [
            [
                'value',
                'key',
                [
                    'key' => 'value',
                ],
            ],
            [
                'quux',
                ['baz', 'qux'],
                [
                    'foo' => 'bar',
                    'baz' => [
                        'qux' => 'quux',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providesValuesByKey
     */
    public function testGetReturnsTheValueOfTheElementWithTheSpecifiedKey($expected, $key, $elements)
    {
        $collection = new Collection($elements);

        $this->assertSame($expected, $collection->get($key));
    }

    public function testSetSetsTheValueOfTheElementWithTheSpecifiedKey()
    {
        $collection = new Collection([]);
        $something = $collection->set('foo', ['bar' => 'qux']);

        $this->assertEquals(['bar' => 'qux'], $collection->get('foo'));
        $this->assertSame($collection, $something);
    }

    public function testGetselectionReturnsASelectionOfValues()
    {
        $collection = new Collection([
            'foo' => 'bar',
            'baz' => [
                'qux' => 'quux',
            ],
        ]);

        $this->assertEquals([
            'foo' => 'bar',
            'baz.qux' => 'quux',
        ], $collection->getSelection(['foo', ['baz', 'qux']]));
    }
}
