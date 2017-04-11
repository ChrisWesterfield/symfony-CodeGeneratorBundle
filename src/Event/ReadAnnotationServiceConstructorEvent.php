<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\ReadAnnotationService;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ReadAnnotationServiceConstructorEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
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
