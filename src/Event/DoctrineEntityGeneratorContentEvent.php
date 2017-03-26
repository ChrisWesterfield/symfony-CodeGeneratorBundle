<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\DoctrineEntityGenerator;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DoctrineEntityGeneratorContentEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class DoctrineEntityGeneratorContentEvent extends Event
{
    /**
     * @var DoctrineEntityGenerator
     */
    protected $subject;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return DoctrineEntityGenerator
     */
    public function getSubject(): DoctrineEntityGenerator
    {
        return $this->subject;
    }

    /**
     * @param DoctrineEntityGenerator $subject
     *
     * @return DoctrineEntityGeneratorContentEvent
     */
    public function setSubject(DoctrineEntityGenerator $subject): DoctrineEntityGeneratorContentEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return DoctrineEntityGeneratorContentEvent
     */
    public function setContent(string $content): DoctrineEntityGeneratorContentEvent
    {
        $this->content = $content;

        return $this;
    }
}
