<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\Service;
use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ServiceTagGeneratorEvent;
use MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\SubDriverInterface;

/**
 * Class ServiceTagGenerator
 *
 * @package MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\Service
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
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
