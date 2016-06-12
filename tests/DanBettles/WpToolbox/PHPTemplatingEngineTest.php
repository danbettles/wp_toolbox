<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Tests\DanBettles\WpToolbox\PHPTemplatingEngine;

use DanBettles\WpToolbox\PHPTemplatingEngine;

class TestCase extends \PHPUnit_Framework_TestCase
{
    private static function createFixtureFilename($basename)
    {
        return __DIR__ . "/PHPTemplatingEngineTest/{$basename}";
    }

    public function testIsInstantiable()
    {
        new PHPTemplatingEngine();
    }

    public function testCreateReturnsANewInstance()
    {
        $engine = PHPTemplatingEngine::create();

        $this->assertInstanceOf('DanBettles\WpToolbox\PHPTemplatingEngine', $engine);
    }

    public static function providesRenderedTemplateOutput()
    {
        return [
            [
                '',
                self::createFixtureFilename('template_1.php'),
                [],
            ],
            [
                'Foo!',
                self::createFixtureFilename('template_2.php'),
                ['message' => 'Foo!'],
            ],
            [
                <<<END
<ul>
    <li>Buddha</li>
    <li>Dharma</li>
    <li>Sangha</li>
</ul>
END
                ,
                self::createFixtureFilename('template_3.php'),
                ['jewels' => ['Buddha', 'Dharma', 'Sangha']],
            ],
        ];
    }

    /**
     * @dataProvider providesRenderedTemplateOutput
     */
    public function testRenderRendersTheSpecifiedTemplate($expected, $filename, array $vars)
    {
        $this->assertSame($expected, PHPTemplatingEngine::create()->render($filename, $vars));
    }
}
