<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class Bundle
 *
 * @package MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Bundle
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $nameSpace;
    /**
     * @var string
     */
    protected $targetDirectory;
    /**
     * @var string
     */
    protected $configurationFormat;
    /**
     * @var bool
     */
    protected $shared;
    /**
     * @var string
     */
    protected $testsDirectory;
    /**
     * @var bool
     */
    protected $createSource;
    /**
     * @var bool
     */
    protected $createComposer;
    /**
     * @var bool
     */
    protected $createDefaultController;

    /**
     * @var bool
     */
    protected $useRouteUpdates;

    /**
     * @var bool
     */
    protected $updateKernel;

    /**
     * Bundle constructor.
     *
     * @param $settings
     */
    public function __construct($settings)
    {
        foreach ($settings as $setting => $value)
        {
            if (property_exists(Bundle::class, $setting))
            {
                $this->{$setting} = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->nameSpace;
    }

    /**
     * @param string $nameSpace
     */
    public function setNameSpace(string $nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return rtrim($this->targetDirectory, '/') . '/' . trim(strtr($this->nameSpace, '\\', '/'), '/');
    }

    /**
     * @param string $targetDirectory
     */
    public function setTargetDirectory(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @return string
     */
    public function getConfigurationFormat(): string
    {
        return $this->configurationFormat;
    }

    /**
     * @param string $configurationFormat
     */
    public function setConfigurationFormat(string $configurationFormat)
    {
        $this->configurationFormat = $configurationFormat;
    }

    /**
     * @return bool
     */
    public function isShared(): bool
    {
        return $this->shared;
    }

    /**
     * @param bool $shared
     */
    public function setShared(bool $shared)
    {
        $this->shared = $shared;
    }

    /**
     * @return string
     */
    public function getTestsDirectory(): string
    {
        if($this->testsDirectory === null)
        {
            $this->testsDirectory = $this->getTargetDirectory().'/'.'Tests';
        }
        return $this->testsDirectory;
    }

    /**
     * @param string $testsDirectory
     */
    public function setTestsDirectory(string $testsDirectory)
    {
        $this->testsDirectory = $testsDirectory;
    }

    /**
     * @return bool
     */
    public function isCreateSource(): bool
    {
        return $this->createSource;
    }

    /**
     * @param bool $createSource
     */
    public function setCreateSource(bool $createSource)
    {
        $this->createSource = $createSource;
    }

    /**
     * @return bool
     */
    public function isCreateComposer(): bool
    {
        return $this->createComposer;
    }

    /**
     * @param bool $createComposer
     */
    public function setCreateComposer(bool $createComposer)
    {
        $this->createComposer = $createComposer;
    }

    /**
     * @return bool
     */
    public function isCreateDefaultController(): bool
    {
        return $this->createDefaultController;
    }

    /**
     * @param bool $createDefaultController
     */
    public function setCreateDefaultController(bool $createDefaultController)
    {
        $this->createDefaultController = $createDefaultController;
    }

    /**
     * @return bool|string
     */
    public function getBasename()
    {
        return substr($this->name, 0, -6);
    }

    /**
     * @return string
     */
    public function getExtensionAlias()
    {
        return Container::underscore($this->getBasename());
    }

    /**
     * @return mixed
     */
    public function shouldGenerateDependencyInjectionDirectory()
    {
        return $this->shared;
    }

    /**
     * @return string
     */
    public function getServicesConfigurationFilename()
    {
        if ('yml' === $this->getConfigurationFormat() || 'annotation' === $this->configurationFormat)
        {
            return 'services.yml';
        }

        return 'services.' . $this->getConfigurationFormat();
    }

    /**
     * @return bool|string
     */
    public function getRoutingConfigurationFilename()
    {
        if ($this->getConfigurationFormat() === 'annotation')
        {
            return false;
        }

        return 'routing.' . $this->getConfigurationFormat();
    }

    /**
     * @return string
     */
    public function getBundleClassName()
    {
        return $this->nameSpace.'\\'.$this->name;
    }

    /**
     * @return bool
     */
    public function isUseRouteUpdates(): bool
    {
        if($this->useRouteUpdates === null)
        {
            $this->useRouteUpdates = false;
        }
        return $this->useRouteUpdates;
    }

    /**
     * @param bool $useRouteUpdates
     *
     * @return Bundle
     */
    public function setUseRouteUpdates(bool $useRouteUpdates): Bundle
    {
        $this->useRouteUpdates = $useRouteUpdates;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUpdateKernel(): bool
    {
        if($this->updateKernel === null)
        {
            $this->updateKernel = false;
        }
        return $this->updateKernel;
    }

    /**
     * @param bool $updateKernel
     *
     * @return Bundle
     */
    public function setUpdateKernel(bool $updateKernel): Bundle
    {
        $this->updateKernel = $updateKernel;

        return $this;
    }
}
