<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\VirtualFileSystemGenerator;

/**
 * Class VirtualFileSystem
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
final class VirtualFileSystem implements CG\SubDriverInterface, CG\ClassInterface, CG\PropertyInterface
{
    const DRIVER = VirtualFileSystemGenerator::class;
    /**
     * @var string
     */
    public $directory;

    /**
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * @param string $directory
     *
     * @return VirtualFileSystem
     */
    public function setDirectory(string $directory): VirtualFileSystem
    {
        $this->directory = $directory;

        return $this;
    }
}
