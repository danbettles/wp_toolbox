<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox;

class Registry
{
    /**
     * @var Registry
     */
    private static $instance;

    /**
     * @var array
     */
    private $elements;

    /**
     * `Registry` is intended to be used as a singleton; in which case, you should get the single instance of the class
     * by calling `getInstance()`.
     */
    public function __construct()
    {
        $this->elements = [];
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
     * @return Registry
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;

        return $this;
    }

    /**
     * Returns the value of the element with the specified key.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->elements[$key];
    }

    /**
     * Sets the single instance of the class.
     *
     * @param Registry $instance
     */
    public static function setInstance(Registry $instance)
    {
        self::$instance = $instance;
    }

    /**
     * Returns the single instance of the class.
     *
     * @return Registry
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::setInstance(new self());
        }

        return self::$instance;
    }
}
