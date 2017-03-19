<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Services\RouterService;
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
class GenerateRoutingCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure(): void
    {
        $this
            ->setName('mjr:generateRouting')
            ->setDescription('Generates a bundle Routing')
            ->addOption(
                'bundle', 'b', InputOption::VALUE_OPTIONAL,
                'Update only certain Bundle (Full Path to Bundle, coma seperated. Use \\\\ for Full Namespace)'
            )
            ->addArgument('cleanup', InputArgument::OPTIONAL, 'remove Not Found Options');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->getContainer()->get('mjrone.codegenerator.router')->setOutput($output);
        /** @var RouterService $service */
        $service->setInput($input)->process();
    }
}
