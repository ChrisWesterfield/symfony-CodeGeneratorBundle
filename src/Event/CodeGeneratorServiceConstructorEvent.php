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

class CodeGeneratorServiceConstructorEvent extends Event
{
    /**
     * @var CodeGeneratorService
     */
    protected $subject;

    /**
     * @return CodeGeneratorService
     */
    public function getSubject(): CodeGeneratorService
    {
        return $this->subject;
    }

    /**
     * @param CodeGeneratorService $subject
     *
     * @return CodeGeneratorServiceConstructorEvent
     */
    public function setSubject(CodeGeneratorService $subject
    ): CodeGeneratorServiceConstructorEvent
    {
        $this->subject = $subject;

        return $this;
    }
}
