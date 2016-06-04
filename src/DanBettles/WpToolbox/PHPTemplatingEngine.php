<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox;

class PHPTemplatingEngine
{
    /**
     * @param string $filename
     * @param array [$vars = array()]
     * @return string
     */
    public function render($filename, array $vars = [])
    {
        extract($vars);

        ob_start();
        require $filename;
        $output = ob_get_clean();

        return $output;
    }

    /**
     * @return PHPTemplatingEngine
     */
    public static function create()
    {
        return new self();
    }
}
