<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\CodeGenerators;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Command\GenerateCodeCommand;
use MjrOne\CodeGeneratorBundle\Exception\BundleDoesNotExistException;
use MjrOne\CodeGeneratorBundle\Services\AbstractService;
use MjrOne\CodeGeneratorBundle\Services\CodeGeneratorInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class BundleGeneratorService
 *
 * @package   MjrOne\CodeGeneratorBundle\CodeGenerators
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class BundleGeneratorService extends AbstractService implements CodeGeneratorInterface
{
    /**
     * @var CodeGeneratorService
     */
    protected $generatorService;
    /**
     * @var string Path to Bundle
     */
    protected $bundle;

    /**
     * @var bool
     */
    protected $verbose = false;

    /**
     * @var GenerateCodeCommand
     */
    protected $command;

    /**
     * BundleGeneratorService constructor.
     *
     * @param CodeGeneratorService $cg
     */
    public function __construct(CodeGeneratorService $cg)
    {
        $this->generatorService = $cg;
    }

    /**
     * @return GenerateCodeCommand
     */
    public function getCommand(): GenerateCodeCommand
    {
        return $this->command;
    }

    /**
     * @param GenerateCodeCommand $command
     *
     * @return BundleGeneratorService
     */
    public function setCommand(GenerateCodeCommand $command): BundleGeneratorService
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerbose(): bool
    {
        return $this->verbose;
    }

    /**
     * @param bool $verbose
     *
     * @return BundleGeneratorService
     */
    public function setVerbose(bool $verbose): BundleGeneratorService
    {
        $this->verbose = $verbose;

        return $this;
    }

    /**
     * @param string $bundle (full Path to a bundle for search
     *
     * @return void
     */
    public function setBundle(string $bundle): void
    {
        $this->bundle = $bundle;
    }

    /**
     * @return CodeGeneratorService
     */
    protected function getGeneratorService(): CodeGeneratorService
    {
        return $this->generatorService;
    }

    /**
     * @return string
     */
    protected function getBundle(): string
    {
        return $this->bundle;
    }

    /**
     * @param string $file
     *
     * @deprecated
     */
    public function setFile($file): void
    {
        $this->setBundle($file);
    }

    public function process()
    {
        $fs = new Filesystem();
        if (!$fs->exists($this->getBundle()))
        {
            throw new BundleDoesNotExistException(
                'The Bundle with the path ' . $this->getBundle() . ' does not exist!'
            );
        }
        $finder = new Finder();
        $finder->files()->in($this->getBundle())->notPath('Traits/')->notPath('Tests/')->name('*.php');
        /**
         *
         */
        $command = $this->getCommand()->getApplication()->find('mjr:generateCode');
        foreach ($finder as $file)
        {
            $argument = [
                'command' => 'mjr:generateCode',
                'file'    => $file->getRealPath() . '/' . $file->getBasename(),
                'verbose' => $this->isVerbose(),
            ];
            $inputObject = new ArrayInput($argument);
            $returnCode = $command->run($inputObject, $this->output);
            if ($returnCode !== 0)
            {
                throw new \RuntimeException(
                    'Command not finished Executing 0. Parameters: ' . json_encode($argument) . ' - file '
                    . $file->getRealPath() . '/' . $file->getBasename()
                );
            }
        }
    }
}
