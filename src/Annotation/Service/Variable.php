<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Service;

use Doctrine\Common\Annotations\Annotation\Target;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class OptionalPropertyType
 *
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * @package MjrOne\CodeGeneratorBundle\Annotation\Service
 * @Target({"ANNOTATION","CLASS","PROPERTY"})
 * @Annotation
 */
final class Variable extends AbstractAnnotation implements CG\AnnotationInterface
{
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $name;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Variable
     */
    public function setType(string $type): Variable
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Variable
     */
    public function setName(string $name): Variable
    {
        $this->name = $name;

        return $this;
    }
}
