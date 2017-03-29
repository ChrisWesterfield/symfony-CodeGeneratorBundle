<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Service\Property;
use MjrOne\CodeGeneratorBundle\Document\Property as PropertyDocument;
use MjrOne\CodeGeneratorBundle\Event\ServicePropertiesGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Generator\Driver\SubDriverInterface;

/**
 * Class ServicePropertiesGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\Service
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ServicePropertiesGenerator extends SubGeneratorAbstract implements SubDriverInterface
{
    /**
     * @return void
     */
    public function process(): void
    {
        $templateProperties = new ArrayCollection();
        $event =
            (new ServicePropertiesGeneratorEvent())->setConfig($this->config)->setTemplateVariables($templateProperties)
                                                   ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preProcess'), $event);
        $templateProperties = $event->getTemplateVariables();
        $this->config = $event->getConfig();
        $serviceName = $this->getTemplateVariables()->get('serviceName');

        foreach ($this->getDocumentAnnotation()->getProperties() as $property)
        {
            if ($property->getAnnotations()->count() > 0)
            {
                /** @var Property $annotation */
                $annotation = null;
                foreach ($property->getAnnotations() as $annotation)
                {
                    if ($annotation instanceof Property)
                    {
                        if ($annotation->isIgnore())
                        {
                            return;
                        }
                        break(1);
                    }
                }
                if (!$annotation instanceof Property)
                {
                    continue;
                }
                $event = (new ServicePropertiesGeneratorEvent())->setConfig($this->config)->setTemplateVariables(
                    $templateProperties
                )->setSubject($this)->setAnnotation($annotation);
                $this->getED()->dispatch($this->getED()->getEventName(self::class, 'perProperty'), $event);
                $templateProperties = $event->getTemplateVariables();
                $this->config = $event->getConfig();
                $annotation = $event->getAnnotation();

                $propertySet = $this->processProperty($annotation, $property);
                $templateProperties->add($propertySet);
                $this->config['services'][$serviceName]['arguments'][] = $annotation->getService();
                $event = (new ServicePropertiesGeneratorEvent())->setConfig($this->config)->setTemplateVariables(
                    $templateProperties
                )->setSubject($this)->setAnnotation($annotation);
                $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postProperty'), $event);
                $templateProperties = $event->getTemplateVariables();
                $this->config = $event->getConfig();
                $serviceName = $this->getTemplateVariables()->get('serviceName');
            }
        }
        $event =
            (new ServicePropertiesGeneratorEvent())->setConfig($this->config)->setTemplateVariables($templateProperties)
                                                   ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postProcess'), $event);
        $templateProperties = $event->getTemplateVariables();
        $this->config = $event->getConfig();
        $serviceName = $this->getTemplateVariables()->get('serviceName');
        $this->getTemplateVariables()->set('properties', $templateProperties->toArray());
        $event =
            (new ServicePropertiesGeneratorEvent())->setConfig($this->config)->setTemplateVariables($templateProperties)
                                                   ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preList'), $event);
        $templateProperties = $event->getTemplateVariables();
        $this->config = $event->getConfig();
        $this->addUseList();
        $event =
            (new ServicePropertiesGeneratorEvent())->setConfig($this->config)->setTemplateVariables($templateProperties)
                                                   ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postList'), $event);
        $templateProperties = $event->getTemplateVariables();
        $this->config = $event->getConfig();
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Service\Property $annotation
     * @param \MjrOne\CodeGeneratorBundle\Document\Property           $doc
     *
     * @return array
     */
    protected function processProperty(Property $annotation, PropertyDocument $doc)
    {

        if ($annotation->getName() === null)
        {
            $annotation->setName($doc->getField());
        }
        $set = [
            'name'          => $annotation->getName(),
            'fqdn'          => $annotation->getClassName(),
            'short'         => $annotation->getClassShort(),
            'service'       => $annotation->getService(),
            'generatedName' => $annotation->getGeneratedName(),
            'alias'         => $annotation->getClassAlias(),
        ];
        /** @var CG\Service\Construction[] $consturctorMethods */
        $consturctorMethods = $annotation->getConstructorMethod();
        $conMethods = [];
        if (!empty($consturctorMethods))
        {
            foreach ($consturctorMethods as $method)
            {
                $subSet = $method->toArray();
                if (!empty($subSet['variables']))
                {
                    foreach ($subSet['variables'] as $id => $value)
                    {
                        /** @var CG\Service\Variable $value */
                        $subSet['variables'][$id] = $value->toArray();
                    }
                }
                $conMethods[] = $subSet;
            }
        }
        $set['constructorMethod'] = $conMethods;
        if ($set['short'] === null || $set['alias'] === null)
        {
            if ($set['fqdn'][0] !== '\\')
            {
                $set['fqdn'] = '\\' . $set['fqdn'];
            }
        }
        if ($set['short'] === null || $set['alias'] !== null)
        {
            $set['short'] = $set['alias'];
        }
        if (empty($set['generatedName']))
        {
            $set['generatedName'] = ucfirst($annotation->getName());
        }
        if (strpos($set['fqdn'], '#') !== false)
        {
            $set['fqdn'] = explode('#', $set['fqdn']);
        }
        if (!empty($annotation->getOptional()))
        {
            /** @var CG\Service\Optional $optional */
            $optional = $annotation->getOptional();
            $set['optional'] = [];
            foreach ($optional->getVariables() as $option)
            {
                /** @var CG\Service\Variable $optional */
                $set['optional'][] = $option->toArray();
            }
            $set['generateSetter'] = !$optional->isIgnore();
        }

        return $set;
    }

    protected function addUseList()
    {
        /** @var array $properties */
        $properties = $this->getTemplateVariables()->get('properties');
        /** @var ArrayCollection $list */
        $list = $this->getTemplateVariables()->get('useList');
        if (!empty($properties))
        {
            foreach ($properties as $property)
            {
                if (!empty($property['short']) || !empty($property['alias']))
                {
                    $alias = !empty($property['alias']) ? $property['alias'] : null;
                    $this->addToList($property['fqdn'], $list, $alias);
                }
            }
        }
        $this->getTemplateVariables()->set('useList', $list);
    }
}
