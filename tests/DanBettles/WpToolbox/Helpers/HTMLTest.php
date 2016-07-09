<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Tests\DanBettles\WpToolbox\Helpers\HTML;

use DanBettles\WpToolbox\Helpers\HTML;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function testCreatetagCreatesATag()
    {
        $html = new HTML();

        $this->assertSame(
            '<p>Lorem ipsum dolor.</p>',
            $html->createTag('p', 'Lorem ipsum dolor.')
        );

        $this->assertSame(
            '<img src="pretty.jpg" alt="A pretty picture"/>',
            $html->createTag('img', null, ['src' => 'pretty.jpg', 'alt' => 'A pretty picture'])
        );
    }

    public function testCreateselectCreatesASelectTag()
    {
        $html = new HTML();

        $selectHtml = $html->createSelect([
            0 => 'Buddha',
            1 => 'Dharma',
            2 => 'Sangha',
        ], 1, [
            'id' => 'three-jewels',
        ]);

        $this->assertSame(
            '<select id="three-jewels"><option value="0">Buddha</option><option value="1" selected="selected">Dharma</option><option value="2">Sangha</option></select>',
            $selectHtml
        );
    }

    public function testCreateselectIsStrictInMarkingTheSelectedOption()
    {
        $html = new HTML();

        $selectHtml = $html->createSelect([
            '' => 'Please select a jewel',
            0 => 'Buddha',
            1 => 'Dharma',
            2 => 'Sangha',
        ], '');

        $this->assertSame(
            '<select><option value="" selected="selected">Please select a jewel</option><option value="0">Buddha</option><option value="1">Dharma</option><option value="2">Sangha</option></select>',
            $selectHtml
        );
    }

    public function testCreatetelanchorReturnsATelAnchor()
    {
        $html = new HTML();

        $this->assertSame(
            '<a href="tel:01234567890">01234 567890</a>',
            $html->createTelAnchor('01234 567890')
        );
    }

    public function testCreatesTagsMagically()
    {
        $html = new HTML();

        $this->assertSame(
            '<h1 id="main">Main Heading</h1>',
            $html->h1('Main Heading', ['id' => 'main'])
        );

        $this->assertSame(
            '<br/>',
            $html->br()
        );
    }

    public static function providesTextParagraphs()
    {
        return [[
            '<p>something</p>',
            'something',
        ], [
            '<p>foo</p><p>bar</p>',
            "foo\n\nbar",
        ], [
            '<p>foo</p><p>bar</p>',
            "foo\n\n\n\nbar",
        ], [
            '<p>foo</p><p>bar</p>',
            "foo\r\n\r\nbar",
        ], [
            '<p>foo<br/>bar</p>',
            "foo\nbar",
        ], [
            '<p>something</p>',
            "something\n\n",
        ], [
            '<p>something</p>',
            "\n\nsomething",
        ]];
    }

    /**
     * @dataProvider providesTextParagraphs
     */
    public function testParagraphizeWrapsParagraphsInTheSpecifiedTextWithParagraphTags($expected, $input)
    {
        $html = new HTML();

        $this->assertSame($expected, $html->paragraphize($input));
    }

    public static function providesEscapedStrings()
    {
        return [[
            '',
            '',
        ], [
            'foo',
            'foo',
        ], [
            'Drum &amp; Bass',
            'Drum & Bass',
        ], [
            "Sophie's World",
            "Sophie's World",
        ], [
            '&quot;The Life of Milarepa&quot; by Tsangnyon Heruka',
            '"The Life of Milarepa" by Tsangnyon Heruka',
        ]];
    }

    /**
     * @dataProvider providesEscapedStrings
     */
    public function testEscapeEscapesTheSpecifiedString($expected, $input)
    {
        $html = new HTML();

        $this->assertSame($expected, $html->escape($input));
    }

    public function testCreatetagEscapesAttributeValues()
    {
        $html = new HTML();

        $this->assertSame(
            '<img src="pretty.jpg" alt="&quot;Hubble Captures Vivid Auroras in Jupiter\'s Atmosphere&quot; by NASA Goddard Space Flight Center"/>',
            $html->createTag('img', null, [
                'src' => 'pretty.jpg',
                'alt' => '"Hubble Captures Vivid Auroras in Jupiter\'s Atmosphere" by NASA Goddard Space Flight Center',
            ])
        );
    }

    public function testAttributeValuesInTagsCreatedByMagicAreEscaped()
    {
        $html = new HTML();

        $this->assertSame(
            '<img src="pretty.jpg" alt="&quot;Hubble Captures Vivid Auroras in Jupiter\'s Atmosphere&quot; by NASA Goddard Space Flight Center"/>',
            $html->img(null, [
                'src' => 'pretty.jpg',
                'alt' => '"Hubble Captures Vivid Auroras in Jupiter\'s Atmosphere" by NASA Goddard Space Flight Center',
            ])
        );
    }
}
