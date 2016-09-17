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
        $engine1 = new PHPTemplatingEngine();

        $this->assertEquals([], $engine1->getPathAliases());

        $engine2 = new PHPTemplatingEngine([
            'bar' => '/foo/bar',
            'quux' => '/foo/bar/baz/qux/quux'
        ]);

        $this->assertEquals([
            'bar' => '/foo/bar',
            'quux' => '/foo/bar/baz/qux/quux'
        ], $engine2->getPathAliases());
    }

    public function testCreateReturnsANewInstance()
    {
        $engine1 = PHPTemplatingEngine::create();

        $this->assertInstanceOf('DanBettles\WpToolbox\PHPTemplatingEngine', $engine1);

        $engine2 = PHPTemplatingEngine::create(['foo' => 'bar']);

        $this->assertInstanceOf('DanBettles\WpToolbox\PHPTemplatingEngine', $engine2);
        $this->assertEquals(['foo' => 'bar'], $engine2->getPathAliases());
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
    public function testRenderRendersTheTemplateWithTheSpecifiedFilename($expected, $filename, array $vars)
    {
        $engine = new PHPTemplatingEngine();

        $this->assertSame($expected, $engine->render($filename, $vars));
    }

    public function testRenderRendersTheTemplateWithTheSpecifiedShortenedFilename()
    {
        $engine = new PHPTemplatingEngine([
            'path_alias' => self::createFixtureFilename('aliased_1'),
        ]);

        $this->assertSame('Hello, World!', $engine->render('path_alias/template.php', ['name' => 'World']));
    }

    public function testAddpathaliasAddsAPathAlias()
    {
        $engine = PHPTemplatingEngine::create(['foo' => 'path/to/foo'])
            ->addPathAlias('bar', 'path/to/bar')
        ;

        $this->assertEquals([
            'foo' => 'path/to/foo',
            'bar' => 'path/to/bar',
        ], $engine->getPathAliases());
    }
}
