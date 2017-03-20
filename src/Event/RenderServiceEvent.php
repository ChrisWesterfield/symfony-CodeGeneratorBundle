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
 * Time: 02:36
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\RenderService;
use Symfony\Component\EventDispatcher\Event;

class RenderServiceEvent extends Event
{
    /**
     * @var RenderService
     */
    protected $subject;
    /**
     * @var string
     */
    protected $template;
    /**
     * @var array
     */
    protected $vars;
    /**
     * @var string
     */
    protected $content;

    /**
     * @return \MjrOne\CodeGeneratorBundle\Services\RenderService
     */
    public function getSubject(): \MjrOne\CodeGeneratorBundle\Services\RenderService
    {
        return $this->subject;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Services\RenderService $subject
     *
     * @return RenderServiceEvent
     */
    public function setSubject(\MjrOne\CodeGeneratorBundle\Services\RenderService $subject): RenderServiceEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return RenderServiceEvent
     */
    public function setTemplate(string $template): RenderServiceEvent
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * @param array $vars
     *
     * @return RenderServiceEvent
     */
    public function setVars(array $vars): RenderServiceEvent
    {
        $this->vars = $vars;

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
     * @return RenderServiceEvent
     */
    public function setContent(string $content): RenderServiceEvent
    {
        $this->content = $content;

        return $this;
    }


}
