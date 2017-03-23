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
 * Time: 13:15
 */

namespace MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ServiceAliasGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver\SubDriverInterface;

class ServiceAliasGenerator extends SubGeneratorAbstract implements SubDriverInterface
{
    /**
     * @return void
     */
    public function process():void
    {
        /** @var CG\Service\Alias $annotation */
        $annotation = $this->getAnnotation();
        $event = (new ServiceAliasGeneratorEvent())->setSubject($this)->setConfig($this->config)->setAnnotation($annotation);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $this->config = $event->getConfig();
        $alias = [
            'alias'=>$annotation->getAlias(),
        ];
        if($annotation->depricated)
        {
            $alias['deprecated'] = '~';
            if(!emptY($annotation->getDepricatedMessage()))
            {
                $alias['deprecated'] = $annotation->getDepricatedMessage();
            }
        }
        if($annotation->getPublicService()!==null)
        {
           $alias['public'] = $annotation->getPublicService();
        }
        $this->config['services'][$annotation->getName()] = $alias;
        $event = (new ServiceAliasGeneratorEvent())->setSubject($this)->setConfig($this->config)->setAnnotation($annotation);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $this->config = $event->getConfig();
    }


}
