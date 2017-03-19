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
