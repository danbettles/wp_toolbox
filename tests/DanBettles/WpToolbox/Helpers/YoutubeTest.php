<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Tests\DanBettles\WpToolbox\Helpers\Youtube;

use DanBettles\WpToolbox\Helpers\Youtube;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public static function providesVideoIds()
    {
        return [[
            'NiCAZcr-tpk',
            'https://www.youtube.com/watch?v=NiCAZcr-tpk',
        ], [
            'NiCAZcr-tpk',
            '<iframe width="854" height="480" src="https://www.youtube.com/embed/NiCAZcr-tpk" frameborder="0" allowfullscreen></iframe>',
        ], [
            'NiCAZcr-tpk',
            'https://www.youtube.com/embed/NiCAZcr-tpk',
        ], [
            'NiCAZcr-tpk',
            'NiCAZcr-tpk',
        ]];
    }

    /**
     * @dataProvider providesVideoIds
     */
    public function testExtractvideoidReturnsTheIdOfTheVideo($expected, $input)
    {
        $this->assertSame($expected, Youtube::extractVideoId($input));
    }
}
