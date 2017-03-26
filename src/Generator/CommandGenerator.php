<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class CommandGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CommandGenerator extends GeneratorAbstract
{

    const BUNDLE_TWIG_NAMESPACE = 'MjrOneCodeGeneratorBundle:Command:';

    /**
     * @param \Symfony\Component\HttpKernel\Bundle\BundleInterface $bundle
     * @param                                                      $name
     */
    public function generate(BundleInterface $bundle, $name)
    {
        $bundleDir = $bundle->getPath();
        if ($this->hasBundleSrcDirectoryStructure($bundleDir))
        {
            $bundleDir = '/' . self::DIRECTORY_SRC;
        }
        $commandDir = $bundleDir . '/Command';
        self::mkdir($commandDir);

        $commandClassName = $this->classify($name) . self::DIRECTORY_COMMAND;
        $commandFile = $commandDir . '/' . $commandClassName . self::FILE_EXTENSION_PHP;
        if ($this->getFileSystem()->exists($commandFile))
        {
            throw new \RuntimeException(sprintf('Command "%s" already exists', $name));
        }

        $parameters = array(
            'namespace'     => $bundle->getNamespace(),
            'class_name'    => $commandClassName,
            'name'          => $name,
            'configuration' => $this->getConfiguration()->toArray(),
        );

        $this->renderFile(
            self::BUNDLE_TWIG_NAMESPACE . 'command.php.twig',
            $commandFile,
            $parameters
        );
    }

    /**
     * @param string $string
     *
     * @return string The string transformed to be a valid PHP class name
     */
    public function classify($string)
    {
        return str_replace(' ', '', ucwords(strtr($string, '_-:', '   ')));
    }
}
