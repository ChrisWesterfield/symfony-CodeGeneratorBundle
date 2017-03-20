<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 19/03/2017
 * Time: 01:10
 */

namespace MjrOne\CodeGeneratorBundle\Annotation\Service;

use Doctrine\Common\Annotations\Annotation\Target;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class OptionalPropertyType
 *
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
