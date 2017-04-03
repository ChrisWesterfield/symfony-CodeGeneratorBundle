<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Manipulators;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class ManipulatorAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Manipulators
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
abstract class ManipulatorAbstract
{
    /**
     * @var array
     */
    protected $tokens;
    /**
     * @var int
     */
    protected $line;

    /**
     * @param array $tokens
     * @param int   $line
     *
     * @return void
     */
    protected function setCode(array $tokens, $line = 0): void
    {
        $this->tokens = $tokens;
        $this->line = $line;
    }

    /**
     * @return string|null
     */
    protected function next()
    {
        while ($token = array_shift($this->tokens))
        {
            $this->line += substr_count($this->value($token), "\n");

            if ($token === (array)$token && in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true))
            {
                continue;
            }

            return $token;
        }

        return null;
    }

    /**
     * @param int $nb
     *
     * @return string|null
     */
    protected function peek($nb = 1)
    {
        $i = 0;
        $tokens = $this->tokens;
        while ($token = array_shift($tokens))
        {
            if ($token === (array)$token && in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true))
            {
                continue;
            }
            ++$i;
            if ($i === $nb)
            {
                return $token;
            }
        }

        return null;
    }

    /**
     * @param string|string[] $token The token value
     *
     * @return string
     */
    protected function value($token): string
    {
        return $token === (array)$token ? $token[1] : $token;
    }
}
