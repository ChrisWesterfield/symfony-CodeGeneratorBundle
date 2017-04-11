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
 * @Target({"ANNOTATION","CLASS", "PROPERTY"})
 * @Annotation
 */
final class Construction extends AbstractAnnotation implements CG\AnnotationInterface
{
    /**
     * @var string
     */
    public $method;
    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Service\Variable>
     */
    public $variables;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return Construction
     */
    public function setMethod(string $method): Construction
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     *
     * @return Construction
     */
    public function setVariables(array $variables): Construction
    {
        $this->variables = $variables;

        return $this;
    }
}
