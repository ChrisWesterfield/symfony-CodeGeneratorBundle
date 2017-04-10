<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorPhpUnit;
use PHPUnit\Framework\TestCase;

/**
 * Class UnitTest
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS"})
 */
final class UnitTest extends AbstractAnnotation implements ClassInterface, DriverInterface
{
    const DRIVER = CodeGeneratorPhpUnit::class;
    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $extends = TestCase::class;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Tests\MockObject>
     */
    public $mocks;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Tests\VirtualFileSystem>
     */
    public $vfs;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Tests\TestFunction>
     */
    public $functions;

    /**
     * @var bool
     */
    public $symfonyController=false;

    /**
     * @var bool
     */
    public $symfonySession=false;

    /**
     * @var bool
     */
    public $container=false;

    /**
     * @var bool
     */
    public $addAllMethodTests=false;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Tests\DataProvider>
     */
    public $dataProvider;

    /**
     * @return bool
     */
    public function isAddAllMethodTests(): bool
    {
        return $this->addAllMethodTests;
    }

    /**
     * @param bool $addAllMethodTests
     * @return UnitTest
     */
    public function setAddAllMethodTests(bool $addAllMethodTests): UnitTest
    {
        $this->addAllMethodTests = $addAllMethodTests;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    /**
     * @param array $dataProvider
     *
     * @return UnitTest
     */
    public function setDataProvider(array $dataProvider): UnitTest
    {
        $this->dataProvider = $dataProvider;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIgnore(): bool
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     *
     * @return UnitTest
     */
    public function setIgnore(bool $ignore): UnitTest
    {
        $this->ignore = $ignore;

        return $this;
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
     *
     * @return UnitTest
     */
    public function setName(string $name): UnitTest
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getMocks()
    {
        return $this->mocks;
    }

    /**
     * @param array $mocks
     *
     * @return UnitTest
     */
    public function setMocks(array $mocks): UnitTest
    {
        $this->mocks = $mocks;

        return $this;
    }

    /**
     * @return array
     */
    public function getVfs()
    {
        return $this->vfs;
    }

    /**
     * @param array $vfs
     *
     * @return UnitTest
     */
    public function setVfs(array $vfs): UnitTest
    {
        $this->vfs = $vfs;

        return $this;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * @param array $functions
     *
     * @return UnitTest
     */
    public function setFunctions(array $functions): UnitTest
    {
        $this->functions = $functions;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSymfonyController(): bool
    {
        return $this->symfonyController;
    }

    /**
     * @param bool $symfonyController
     *
     * @return UnitTest
     */
    public function setSymfonyController(bool $symfonyController): UnitTest
    {
        $this->symfonyController = $symfonyController;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSymfonySession(): bool
    {
        return $this->symfonySession;
    }

    /**
     * @param bool $symfonySession
     *
     * @return UnitTest
     */
    public function setSymfonySession(bool $symfonySession): UnitTest
    {
        $this->symfonySession = $symfonySession;

        return $this;
    }

    /**
     * @return bool
     */
    public function isContainer(): bool
    {
        return $this->container;
    }

    /**
     * @param bool $container
     *
     * @return UnitTest
     */
    public function setContainer(bool $container): UnitTest
    {
        $this->container = $container;

        return $this;
    }
}
