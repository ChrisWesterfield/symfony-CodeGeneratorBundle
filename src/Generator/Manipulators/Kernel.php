<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Manipulators;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\Generator;
use ReflectionObject;
use RuntimeException;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class Kernel
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Manipulators
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Kernel extends ManipulatorAbstract
{
    const CLOSING_SYMBOL_REGEX = '#(\)|])$#';
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var ReflectionObject
     */
    protected $reflection;

    /**
     * @var Generator
     */
    protected $generator;

    /**
     * Kernel constructor.
     *
     * @param KernelInterface $kernel
     * @param Generator       $generator
     */
    public function __construct(KernelInterface $kernel, Generator $generator)
    {
        $this->kernel = $kernel;
        $this->reflection = new ReflectionObject($kernel);
        $this->generator = $generator;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->reflection->getFileName();
    }

    /**
     * @param $bundle
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function addBundle($bundle): bool
    {
        if (!$this->getFilename())
        {
            return false;
        }
        $src = file($this->getFilename());
        $method = $this->getReflection()->getMethod('registerBundles');
        $lines = array_slice($src, $method->getStartLine() - 1, $method->getEndLine() - $method->getStartLine() + 1);
        if (false !== strpos(implode('', $lines), $bundle))
        {
            throw new RuntimeException(
                sprintf('Bundle "%s" is already defined in "AppKernel::registerBundles()".', $bundle)
            );
        }
        $this->setCode(token_get_all('<?php ' . implode('', $lines)), $method->getStartLine());
        while ($token = $this->next())
        {
            if (T_VARIABLE !== $token[0] || '$bundles' !== $token[1])
            {
                continue;
            }
            $this->next();
            $token = $this->next();
            if (T_ARRAY !== $token[0] && '[' !== $this->value($token))
            {
                return false;
            }

            while ($token = $this->next())
            {
                // look for ); or ];
                /** @noinspection NotOptimalIfConditionsInspection */
                if (')' !== $this->value($token) && ']' !== $this->value($token))
                {
                    continue;
                }
                if (';' !== $this->value($this->peek()))
                {
                    continue;
                }
                $this->next();
                $leadingContent = implode('', array_slice($src, 0, $this->line));
                $leadingContent = rtrim(rtrim($leadingContent), ';');
                preg_match(self::CLOSING_SYMBOL_REGEX, $leadingContent, $matches);
                $closingSymbol = $matches[0];
                $leadingContent = rtrim(preg_replace(self::CLOSING_SYMBOL_REGEX, '', rtrim($leadingContent)));
                /** @noinspection NotOptimalIfConditionsInspection */
                if ('(' !== substr($leadingContent, -1) && '[' !== substr($leadingContent, -1))
                {
                    $leadingContent = rtrim($leadingContent, ',') . ',';
                }
                $lines = array_merge(
                    array($leadingContent, "\n"),
                    array(str_repeat(' ', 12), sprintf('new %s(),', $bundle), "\n"),
                    array(str_repeat(' ', 8), $closingSymbol . ';', "\n"),
                    array_slice($src, $this->line)
                );
                $this->generator->dump($this->getFilename(), implode('', $lines));

                return true;
            }
        }

        return false;
    }

    /**
     * @return KernelInterface
     */
    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @return ReflectionObject
     */
    public function getReflection(): ReflectionObject
    {
        return $this->reflection;
    }

    /**
     * @return Generator
     */
    protected function getGenerator(): Generator
    {
        return $this->generator;
    }
}
