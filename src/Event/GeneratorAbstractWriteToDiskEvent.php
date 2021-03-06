<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class GeneratorAbstractWriteToDiskEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class GeneratorAbstractWriteToDiskEvent extends EventAbstract
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $createDirectory = true;

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return GeneratorAbstractWriteToDiskEvent
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return GeneratorAbstractWriteToDiskEvent
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     *
     * @return GeneratorAbstractWriteToDiskEvent
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCreateDirectory(): bool
    {
        return $this->createDirectory;
    }

    /**
     * @param bool $createDirectory
     *
     * @return GeneratorAbstractWriteToDiskEvent
     */
    public function setCreateDirectory(bool $createDirectory): GeneratorAbstractWriteToDiskEvent
    {
        $this->createDirectory = $createDirectory;

        return $this;
    }
}
