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
 * Time: 01:38
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;

class ReadAnnotationServicePropertiesEvent extends ReadAnnotationServiceConstructorEvent
{
    /**
     * @var ArrayCollection
     */
    protected $properties;

    /**
     * @return ArrayCollection
     */
    public function getProperties(): ArrayCollection
    {
        return $this->properties;
    }

    /**
     * @param ArrayCollection $properties
     *
     * @return ReadAnnotationServicePropertiesEvent
     */
    public function setProperties(ArrayCollection $properties): ReadAnnotationServicePropertiesEvent
    {
        $this->properties = $properties;

        return $this;
    }


}
