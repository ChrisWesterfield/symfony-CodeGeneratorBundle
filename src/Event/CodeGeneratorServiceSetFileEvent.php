<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:20
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\CodeGeneratorService;
use Symfony\Component\EventDispatcher\Event;

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
