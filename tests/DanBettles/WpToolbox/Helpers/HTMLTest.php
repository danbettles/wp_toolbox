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
        $helper = new HTML();

        $this->assertSame(
            '<p>Lorem ipsum dolor.</p>',
            $helper->createTag('p', 'Lorem ipsum dolor.')
        );

        $this->assertSame(
            '<img src="pretty.jpg" alt="A pretty picture"/>',
            $helper->createTag('img', null, ['src' => 'pretty.jpg', 'alt' => 'A pretty picture'])
        );
    }

    public function testCreateselectCreatesASelectTag()
    {
        $helper = new HTML();

        $selectHtml = $helper->createSelect([
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
        $helper = new HTML();

        $selectHtml = $helper->createSelect([
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
        $helper = new HTML();

        $this->assertSame(
            '<a href="tel:01234567890">01234 567890</a>',
            $helper->createTelAnchor('01234 567890')
        );
    }

    public function testCreatesTagsMagically()
    {
        $helper = new HTML();

        $this->assertSame(
            '<h1 id="main">Main Heading</h1>',
            $helper->h1('Main Heading', ['id' => 'main'])
        );

        $this->assertSame(
            '<br/>',
            $helper->br()
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
        $helper = new HTML();

        $this->assertSame($expected, $helper->paragraphize($input));
    }
}
