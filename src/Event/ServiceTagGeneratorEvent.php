<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 19/03/2017
 * Time: 17:41
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServiceTagGenerator;
use Symfony\Component\EventDispatcher\Event;

class ServiceTagGeneratorEvent extends Event
{
    /**
     * @var ServiceTagGenerator
     */
    protected $subject;
    /**
     * @var array
     */
    protected $config;

    /**
     * @var CG\Service\Tag
     */
    protected $annotation;

    /**
     * @var array
     */
    protected $postData;

    /**
     * @return array
     */
    public function getPostData(): array
    {
        return $this->postData;
    }

    /**
     * @param array $postData
     *
     * @return ServiceTagGeneratorEvent
     */
    public function setPostData(array $postData): ServiceTagGeneratorEvent
    {
        $this->postData = $postData;

        return $this;
    }

    /**
     * @return ServiceTagGenerator
     */
    public function getSubject(): ServiceTagGenerator
    {
        return $this->subject;
    }

    /**
     * @param ServiceTagGenerator $subject
     *
     * @return ServiceTagGeneratorEvent
     */
    public function setSubject(ServiceTagGenerator $subject
    ): ServiceTagGeneratorEvent
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
     * @return ServiceTagGeneratorEvent
     */
    public function setConfig(array $config): ServiceTagGeneratorEvent
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return CG\Service\Tag
     */
    public function getAnnotation(): CG\Service\Tag
    {
        return $this->annotation;
    }

    /**
     * @param CG\Service\Tag $annotation
     *
     * @return ServiceTagGeneratorEvent
     */
    public function setAnnotation(CG\Service\Tag $annotation
    ): ServiceTagGeneratorEvent
    {
        $this->annotation = $annotation;

        return $this;
    }
}
