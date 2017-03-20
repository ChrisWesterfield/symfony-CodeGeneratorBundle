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
 * Time: 16:20
 */

namespace MjrOne\CodeGeneratorBundle\Annotation\Service;

use MjrOne\CodeGeneratorBundle\Annotation as CG;


/**
 * Class OptionalPropertyType
 *
 * @package MjrOne\CodeGeneratorBundle\Annotation\Service
 * @Target({"ANNOTATION","CLASS", "PROPERTY"})
 * @Annotation
 */
final class Optional
{
    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Service\Variable>
     */
    public $variables;

    /**
     * @var bool
     */
    public $ignore = false;

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
     * @return Optional
     */
    public function setVariables(array $variables): Optional
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIgnore(): bool
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     *
     * @return Optional
     */
    public function setIgnore(bool $ignore): Optional
    {
        $this->ignore = $ignore;

        return $this;
    }
}
