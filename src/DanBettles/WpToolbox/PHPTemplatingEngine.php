<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox;

class PHPTemplatingEngine
{
    /**
     * @var array
     */
    private $pathAliases;

    /**
     * @param array [$pathAliases = array()]
     */
    public function __construct(array $pathAliases = [])
    {
        $this->setPathAliases($pathAliases);
    }

    /**
     * @param string $alias
     * @param string $path
     * @return PHPTemplatingEngine
     */
    public function addPathAlias($alias, $path)
    {
        $this->pathAliases[$alias] = $path;

        return $this;
    }

    /**
     * @param array $pathAliases
     * @return PHPTemplatingEngine
     */
    private function setPathAliases(array $pathAliases)
    {
        $this->pathAliases = [];

        foreach ($pathAliases as $alias => $path) {
            $this->addPathAlias($alias, $path);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPathAliases()
    {
        return $this->pathAliases;
    }

    /**
     * @param string $filename
     * @param array [$vars = array()]
     * @return string
     */
    public function render($filename, array $vars = [])
    {
        $finalFilename = $filename;

        foreach ($this->getPathAliases() as $pathAlias => $path) {
            $expandedFilename = preg_replace('/^' . preg_quote($pathAlias) . '/', $path, $filename);

            if ($expandedFilename !== $filename) {
                $finalFilename = $expandedFilename;
                break;
            }
        }

        extract($vars);

        ob_start();
        require $finalFilename;
        $output = ob_get_clean();

        return $output;
    }

    /**
     * @see PHPTemplatingEngine::__construct()
     * @return PHPTemplatingEngine
     */
    public static function create()
    {
        $class = new \ReflectionClass(get_called_class());

        return $class->newInstanceArgs(func_get_args());
    }
}
