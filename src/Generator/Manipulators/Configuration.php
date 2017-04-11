<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Manipulators;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Bundle;
use MjrOne\CodeGeneratorBundle\Generator\Generator;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Configuration
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Manipulators
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Configuration extends ManipulatorAbstract
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var Generator
     */
    protected $generator;

    /**
     * Configuration constructor.
     *
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     *
     * @return Configuration
     */
    public function setFile(string $file): Configuration
    {
        $this->file = $file;

        return $this;
    }


    /**
     * Adds a configuration resource at the top of the existing ones.
     *
     * @param Bundle $bundle
     *
     * @throws \RuntimeException If this process fails for any reason
     *
     * @return Configuration
     */
    public function addResource(Bundle $bundle): Configuration
    {
        if (!file_exists($this->file))
        {
            throw new RuntimeException(sprintf('The target config file %s does not exist', $this->file));
        }
        $code = $this->getImportCode($bundle);
        $currentContents = file_get_contents($this->file);
        if (false !== strpos($currentContents, $code))
        {
            throw new RuntimeException(
                sprintf(
                    'The %s configuration file from %s is already imported',
                    $bundle->getServicesConfigurationFilename(), $bundle->getName()
                )
            );
        }
        $lastImportedPath = $this->findLastImportedPath($currentContents);
        if (!$lastImportedPath)
        {
            throw new RuntimeException(sprintf('Could not find the imports key in %s', $this->file));
        }
        $importsPosition = strpos($currentContents, 'imports:');
        $lastImportPosition = strpos($currentContents, $lastImportedPath, $importsPosition);
        $targetLinebreakPosition = strpos($currentContents, "\n", $lastImportPosition);

        $newContents = substr($currentContents, 0, $targetLinebreakPosition) . "\n" . $code . substr(
                $currentContents, $targetLinebreakPosition
            );
        if (false === $this->generator->dump($this->file, $newContents))
        {
            throw new RuntimeException(sprintf('Could not write file %s ', $this->file));
        }

        return $this;
    }

    /**
     * @param Bundle $bundle
     *
     * @return string
     */
    public function getImportCode(Bundle $bundle): string
    {
        return sprintf(
            <<<EOF
                - { resource: "@%s/Resources/config/%s" }
EOF
            ,
            $bundle->getName(),
            $bundle->getServicesConfigurationFilename()
        );
    }

    /**
     * @param $yamlContents
     *
     * @return bool|string
     */
    private function findLastImportedPath($yamlContents)
    {
        $data = Yaml::parse($yamlContents);
        if (!isset($data['imports']))
        {
            return false;
        }

        // find the last imports entry
        $lastImport = end($data['imports']);
        if (!isset($lastImport['resource']))
        {
            return false;
        }

        return $lastImport['resource'];
    }
}
