<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class CreateBundleCommand
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class GenerateCodeCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure(): void
    {
        $this
            ->setName('mjr:generateCode')
            ->setDescription('Generate MJRONE Bundle Codes')
            ->addOption(
                'all', 'a', InputOption::VALUE_NONE,
                'Update all Files in Bundle,'
            )->addArgument('file', InputArgument::REQUIRED,'File to Generator Code For');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $file = $input->getArgument('file');
        $options = $input->getOptions();
        if($input->getOption('all'))
        {
            $service = $this->getContainer()->get('mjrone.codegenerator.code.bundle');
            $service->setBundle($file);
            $service->setVerbose($input->getOption('verbose'));
            $service->setCommand($this);
        }
        else
        {
            $service = $this->getContainer()->get('mjrone.codegenerator.code.file');
            $service->setFile($file);
        }
        $service->setInput($input);
        $service->setOutput($output);
        $service->process();
    }
}
