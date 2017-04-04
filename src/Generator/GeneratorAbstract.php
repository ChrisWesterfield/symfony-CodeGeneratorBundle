<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig_Environment;

/**
 * Class GeneratorAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
abstract class GeneratorAbstract implements GeneratorInterface
{
    public const REGEX_ROUTER_PREFIX1 = '/{(.*?)}/';
    public const REGEX_ROUTER_PREFIX2 = '/_+/';
    /**
     * @var string|array
     */
    protected $skeletonDirecotries;
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var ConfiguratorService
     */
    protected $configuration;

    /**
     * @var string
     */
    protected $projectRootDirectory;

    /**
     * @var array
     */
    protected $directoryCache;

    /**
     * GeneratorAbstract constructor.
     *
     * @param Twig_Environment    $twig
     * @param ConfiguratorService $configuration
     */
    public function __construct(Twig_Environment $twig, ConfiguratorService $configuration, KernelInterface $kernel)
    {
        $this->fileSystem = new Filesystem();
        $this->twig = $twig;
        $this->twig->setCache(false);
        $this->twig->enableStrictVariables();
        $this->twig->enableDebug();
        $this->configuration = $configuration;
        if (method_exists($kernel, 'getRealRootDirectory'))
        {
            $this->projectRootDirectory = $kernel->getRealRootDirectory();
        }
        else
        {
            /** @noinspection RealpathInSteamContextInspection */
            $this->projectRootDirectory = realpath($kernel->getRootDir() . '/../');
        }
        $this->directoryCache = [];
    }

    /**
     * @return string
     */
    public function getProjectRootDirectory(): string
    {
        if($this->projectRootDirectory === null)
        {
            return realpath(__DIR__.'/../../../../../');
        }
        return $this->projectRootDirectory;
    }

    /**
     * @return Twig_Environment
     */
    public function getTwigEnvironment(): Twig_Environment
    {
        return $this->twig;
    }

    /**
     * @param string|array $skeletonDirs
     */
    public function setSkeletonDirs($skeletonDirs)
    {
        $this->skeletonDirecotries = $skeletonDirs === (array)$skeletonDirs ? $skeletonDirs : [$skeletonDirs];
    }

    /**
     * @param $template
     * @param $parameters
     *
     * @return string
     */
    public function render($template, $parameters): string
    {
        return $this->getTwigEnvironment()->render($template, $parameters);
    }

    /**
     * @param $template
     * @param $target
     * @param $parameters
     *
     * @return bool|int
     */
    public function renderFile($template, $target, $parameters)
    {
        $this->mkdir(dirname($target));

        return $this->dump($target, $this->render($template, $parameters));
    }

    /**
     * @param     $target
     * @param int $mode
     *
     * @return GeneratorInterface
     */
    public function mkdir($target, $mode = 0777): GeneratorInterface
    {
        if (!$this->fileSystem->exists($target))
        {
            $this->fileSystem->mkdir($target, $mode);
            $this->writeln(sprintf('<fg=green>created</> %s', $this->relativizePath($target)));
        }

        return $this;
    }

    /**
     * @param $filename
     * @param $content
     *
     * @return bool|int
     * @internal
     */
    public function dump($filename, $content)
    {
        if (file_exists($filename))
        {
            $this->writeln(sprintf('  <fg=yellow>updated</> %s', $this->relativizePath($filename)));
        }
        else
        {
            $this->writeln(sprintf('  <fg=green>created</> %s', $this->relativizePath($filename)));
        }

        return file_put_contents($filename, $content);
    }

    /**
     * @param $absolutePath
     *
     * @return mixed|string
     */
    public function relativizePath($absolutePath)
    {
        $relativePath = str_replace(getcwd(), '.', $absolutePath);

        return is_dir($absolutePath) ? rtrim($relativePath, '/') . '/' : $relativePath;
    }

    /**
     * @return array|string
     */
    public function getSkeletonDirecotries()
    {
        return $this->skeletonDirecotries;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * @return Filesystem
     */
    public function getFileSystem(): Filesystem
    {
        return $this->fileSystem;
    }

    /**
     * @return ConfiguratorService
     */
    public function getConfiguration(): ConfiguratorService
    {
        return $this->configuration;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param $message
     */
    public function writeln($message)
    {
        if (null === $this->output)
        {
            $this->setOutput(new ConsoleOutput());
        }

        $this->output->writeln($message);
    }

    /**
     * @param $prefix
     *
     * @return mixed|string
     */
    public function getRouteNamePrefix($prefix)
    {
        $prefix = preg_replace(self::REGEX_ROUTER_PREFIX1, '', $prefix); // {foo}_bar -> _bar
        $prefix = str_replace('/', '_', $prefix);
        $prefix = preg_replace(self::REGEX_ROUTER_PREFIX2, '_', $prefix);     // foo__bar -> foo_bar
        $prefix = trim($prefix, '_');

        return $prefix;
    }

    /**
     * @param $directory
     *
     * @return mixed
     */
    public function hasBundleSrcDirectoryStructure($directory)
    {
        if (!array_key_exists($directory, $this->directoryCache))
        {
            $this->directoryCache[$directory] = $this->getFileSystem()->exists($directory . '/' . self::DIRECTORY_SRC);
        }

        return $this->directoryCache[$directory];
    }
}
