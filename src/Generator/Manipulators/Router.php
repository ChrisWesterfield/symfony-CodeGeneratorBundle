<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Manipulators;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\Generator;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Router
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Manipulators
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Router extends ManipulatorAbstract
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var Generator
     */
    protected $generator;

    /**
     * Router constructor.
     *
     * @param ConfiguratorService $service
     */
    public function __construct(ConfiguratorService $service, Generator $generator)
    {
        $this->file = $service->getRouter()->getProduction();
        $this->generator = $generator;
    }/** @noinspection MoreThanThreeArgumentsInspection */


    /**
     * @param        $bundle
     * @param        $format
     * @param string $prefix
     * @param string $path
     *
     * @return bool
     */
    public function addResource($bundle, $format, $prefix = '/', $path = 'routing'): bool
    {
        $current = '';
        $code = sprintf("%s:\n", $this->getImportedResourceYamlKey($bundle, $prefix));
        if (file_exists($this->file))
        {
            $current = file_get_contents($this->file);

            // Don't add same bundle twice
            if (false !== strpos($current, '@' . $bundle))
            {
                throw new \RuntimeException(sprintf('Bundle "%s" is already imported.', $bundle));
            }
        }
        else if (!is_dir($dir = dirname($this->file)))
        {
            $this->generator->mkdir($dir);
        }
        if ('annotation' === $format)
        {
            $code .= sprintf("    resource: \"@%s/Controller/\"\n    type:     annotation\n", $bundle);
        }
        else
        {
            $code .= sprintf("    resource: \"@%s/Resources/config/%s.%s\"\n", $bundle, $path, $format);
        }
        $code .= sprintf("    prefix:   %s\n", $prefix);
        $code .= "\n";
        $code .= $current;
        if (false === $this->generator->dump($this->file, $code))
        {
            return false;
        }

        return true;
    }

    /**
     * @param $bundle
     *
     * @return bool
     */
    public function hasResourceInAnnotation($bundle): bool
    {
        if (!file_exists($this->file))
        {
            return false;
        }
        $config = Yaml::parse(file_get_contents($this->file));
        $search = sprintf('@%s/Controller/', $bundle);
        foreach ($config as $resource)
        {
            if (array_key_exists('resource', $resource))
            {
                return $resource['resource'] === $search;
            }
        }

        return false;
    }

    /**
     * @param $bundle
     * @param $controller
     *
     * @return bool
     */
    public function addAnnotationController($bundle, $controller): bool
    {
        $current = '';

        if ($this->generator->getFileSystem()->exists($this->file))
        {
            $current = file_get_contents($this->file);
        }
        else if (!is_dir($dir = dirname($this->file)))
        {
            $this->generator->getFileSystem()->mkdir($dir, 0777);
        }

        $code = sprintf(
            "%s:\n",
            Container::underscore(substr($bundle, 0, -6)) . '_' . Container::underscore($controller)
        );

        $code .= sprintf(
            "    resource: \"@%s/Controller/%sController.php\"\n    type:     annotation\n",
            $bundle, $controller
        );

        $code .= "\n";
        $code .= $current;

        return false !== file_put_contents($this->file, $code);
    }

    /**
     * @param $bundle
     * @param $prefix
     *
     * @return string
     */
    public function getImportedResourceYamlKey($bundle, $prefix)
    {
        $snakeCasedBundleName = Container::underscore(substr($bundle, 0, -6));
        $routePrefix = $this->generator->getRouteNamePrefix($prefix);

        return sprintf('%s%s%s', $snakeCasedBundleName, '' !== $routePrefix ? '_' : '', $routePrefix);
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return Generator
     */
    public function getGenerator(): Generator
    {
        return $this->generator;
    }
}
