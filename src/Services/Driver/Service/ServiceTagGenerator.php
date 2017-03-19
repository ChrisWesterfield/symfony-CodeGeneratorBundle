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
 * Time: 13:16
 */

namespace MjrOne\CodeGeneratorBundle\Services\Driver\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ServiceTagGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Services\Driver\SubDriverInterface;

class ServiceTagGenerator extends SubGeneratorAbstract implements SubDriverInterface
{
    /**
     * @return void
     */
    public function process():void
    {
        /** @var CG\Service\Tag $annotation */
        $annotation = $this->getAnnotation();
        $event = (new ServiceTagGeneratorEvent())->setSubject($this)->setAnnotation($annotation)->setConfig($this->config);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $annotation = $event->getAnnotation();
        $this->config = $event->getConfig();
        $serviceName = $this->templateVariables->get('serviceName');
        $set = [
            'name'=>$annotation->getName(),
        ];
        if($annotation->getEvent() !== null)
        {
            $set['event'] = $annotation->getEvent();
        }
        if($annotation->getMethod() !== null)
        {
            $set['method'] = $annotation->getMethod();
        }
        if($annotation->getPriority() !== null)
        {
            $set['priority'] = $annotation->getPriority();
        }
        if($annotation->getChannel() !== null)
        {
            $set['channel'] = $annotation->getChannel();
        }
        if($annotation->getId() !== null)
        {
            $set['id'] = $annotation->getId();
        }
        if($annotation->getTemplate() !== null)
        {
            $set['template'] = $annotation->getTemplate();
        }
        if($annotation->getExtendedType() !== null)
        {
            $set['extended_type'] = $annotation->getExtendedType();
        }

        $event = (new ServiceTagGeneratorEvent())->setSubject($this)->setAnnotation($annotation)->setConfig($this->config)->setPostData($set);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $annotation = $event->getAnnotation();
        $this->config = $event->getConfig();
        $this->getConfig()['services'][$serviceName]['tags'][] = $event->getPostData();
    }
}
