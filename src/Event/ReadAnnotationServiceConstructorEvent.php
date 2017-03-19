<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:20
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\CodeGeneratorService;
use MjrOne\CodeGeneratorBundle\Services\ReadAnnotationService;
use Symfony\Component\EventDispatcher\Event;

class ReadAnnotationServiceConstructorEvent extends Event
{
    /**
     * @var ReadAnnotationService
     */
    protected $subject;

    /**
     * @return ReadAnnotationService
     */
    public function getSubject(): ReadAnnotationService
    {
        return $this->subject;
    }

    /**
     * @param ReadAnnotationService $subject
     *
     * @return ReadAnnotationServiceConstructorEvent
     */
    public function setSubject(ReadAnnotationService $subject
    ): ReadAnnotationServiceConstructorEvent
    {
        $this->subject = $subject;

        return $this;
    }
}