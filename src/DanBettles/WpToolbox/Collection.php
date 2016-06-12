<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox;

class Collection
{
    /**
     * @var array
     */
    private $elements;

    /**
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->replaceElements($elements);
    }

    /**
     * @param array $elements
     * @return Collection
     */
    private function replaceElements(array $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Sets the value of the element with the specified key.
     *
     * @param mixed $key
     * @param mixed $value
     * @return Collection
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;

        return $this;
    }

    /**
     * Returns the value of the element with the specified key, which could be an array identifying a nested element.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        $keyParts = (array) $key;
        $numKeyParts = count($keyParts);

        $elements = $this->toArray();

        foreach ($keyParts as $i => $keyPart) {
            if ($i === $numKeyParts - 1) {
                return $elements[$keyPart];
            }

            $elements = $elements[$keyPart];
        }
    }

    /**
     * Returns a selection of values identified by the specified keys.
     *
     * @param array $keys
     * @return array
     */
    public function getSelection(array $keys)
    {
        $selection = [];

        foreach ($keys as $key) {
            $serializedKey = implode('.', (array) $key);
            $selection[$serializedKey] = $this->get($key);
        }

        return $selection;
    }
}
