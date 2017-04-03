<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\Driver\Service\ServiceAliasGenerator;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ServiceAliasGeneratorEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ServiceAliasGeneratorEvent extends Event
{
    /**
     * @var ServiceAliasGenerator
     */
    protected $subject;
    /**
     * @var array
     */
    protected $config;

    /**
     * @var CG\Service\Alias
     */
    protected $annotation;

    /**
     * @return ServiceAliasGenerator
     */
    public function getSubject(): ServiceAliasGenerator
    {
        return $this->subject;
    }

    /**
     * @param ServiceAliasGenerator $subject
     *
     * @return ServiceAliasGeneratorEvent
     */
    public function setSubject(ServiceAliasGenerator $subject
    ): ServiceAliasGeneratorEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return ServiceAliasGeneratorEvent
     */
    public function setConfig(array $config): ServiceAliasGeneratorEvent
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return CG\Service\Alias
     */
    public function getAnnotation(): CG\Service\Alias
    {
        return $this->annotation;
    }

    /**
     * @param CG\Service\Alias $annotation
     *
     * @return ServiceAliasGeneratorEvent
     */
    public function setAnnotation(CG\Service\Alias $annotation): ServiceAliasGeneratorEvent
    {
        $this->annotation = $annotation;

        return $this;
    }
}
