<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Services\CreateBundleService;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class CreateBundleCommand
 *
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class CreateBundleCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure(): void
    {
        $this
            ->setName('mjr:createBundle')
            ->setDescription('Generates a bundle MJR.ONE')
            ->setDefinition(
                [
                    new InputOption(
                        'namespace', 's', InputOption::VALUE_REQUIRED, 'The namespace of the bundle to create'
                    ),
                    new InputOption(
                        'dir', 'd', InputOption::VALUE_REQUIRED,
                        'The directory where to create the bundle (if default the output is src)'
                    ),
                    new InputOption('bundle-name', 'm', InputOption::VALUE_REQUIRED, 'The optional bundle name'),
                    new InputOption(
                        'format', 'f', InputOption::VALUE_REQUIRED,
                        'Use the format for configuration files (php, xml, yml, or annotation)'
                    ),
                    new InputOption(
                        'defaultController', 't', InputOption::VALUE_OPTIONAL,
                        'Are you planning to add a default Controller?'
                    ),
                    new InputOption(
                        'routing-format', 'r', InputOption::VALUE_REQUIRED,
                        'Use the format for routing files (controller, yml'
                    ),
                    new InputOption(
                        'addKernel', 'k', InputOption::VALUE_OPTIONAL,
                        'Which Kernel should be used or none at all (default)'
                    ),
                    new InputOption(
                        'composer', '', InputOption::VALUE_OPTIONAL,
                        'Create Composer File'
                    ),
                    new InputOption(
                        'placeSrc', '', InputOption::VALUE_OPTIONAL,
                        'Place in src directory'
                    ),
                ]
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $service = $this->getContainer()->get('mjrone.codegenerator.createbundle')->setOutput($output);
        /** @var CreateBundleService $service */
        $service->setInput($input)->process();
    }
}
