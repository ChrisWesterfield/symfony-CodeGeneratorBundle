<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class CodeGeneratorServiceSetFileEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CodeGeneratorServiceSetFileEvent extends CodeGeneratorServiceConstructorEvent
{
    /**
     * @var string
     */
    protected $file;

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
     * @return CodeGeneratorServiceSetFileEvent
     */
    public function setFile(string $file): CodeGeneratorServiceSetFileEvent
    {
        $this->file = $file;

        return $this;
    }
}
