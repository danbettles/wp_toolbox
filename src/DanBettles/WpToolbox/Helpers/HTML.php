<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox\Helpers;

class HTML
{
    /**
     * @var ReflectionMethod
     */
    private $createTag;

    public function __construct()
    {
        $this->createTag = new \ReflectionMethod(__CLASS__, 'createTag');
    }

    public function createTag($tagName, $html = null, array $attributes = [])
    {
        $attributesHTML = '';

        foreach ($attributes as $attrName => $attrValue) {
            $attributesHTML .= " {$attrName}=\"{$attrValue}\"";
        }

        if ($html === null) {
            return "<{$tagName}{$attributesHTML}/>";
        }

        return "<{$tagName}{$attributesHTML}>{$html}</{$tagName}>";
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, array $arguments)
    {
        $createTagArgs = $arguments;
        array_unshift($createTagArgs, $name);

        return $this->createTag->invokeArgs($this, $createTagArgs);
    }

    /**
     * @param array $options
     * @param string|null [$selectedValue = null]
     * @param array [$attributes = array()]
     * @return string
     */
    public function createSelect(array $options, $selectedValue = null, array $attributes = [])
    {
        $optionsHtml = '';

        foreach ($options as $value => $label) {
            $optionAttributes = ['value' => $value];

            if (null !== $selectedValue && 0 === strcmp($selectedValue, $value)) {
                $optionAttributes['selected'] = 'selected';
            }

            $optionsHtml .= $this->option($label, $optionAttributes);
        }

        return $this->select($optionsHtml, $attributes);
    }

    /**
     * @param string $telephoneNumber
     * @return string
     */
    public function createTelAnchor($telephoneNumber)
    {
        return $this->a($telephoneNumber, [
            'href' => 'tel:' . urlencode(str_replace(' ', '', $telephoneNumber)),
        ]);
    }

    /**
     * Wraps paragraphs with paragraph tags and lone new-line characters with line-breaks.
     *
     * @param string $text
     * @return string
     */
    public function paragraphize($text)
    {
        $normalized = preg_replace('/(\r\n|\r|\n)/', "\n", trim($text));

        $paragraphized = '';

        foreach (preg_split('/\n{2,}/', $normalized) as $paragraphContent) {
            $paragraphized .= $this->p(str_replace("\n", $this->br(), $paragraphContent));
        }

        return $paragraphized;
    }
}
