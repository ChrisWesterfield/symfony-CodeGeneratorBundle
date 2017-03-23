<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Services\CodeGeneratorInterface;
use MjrOne\CodeGeneratorBundle\Services\RouterService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            ->addArgument('cleanup', InputArgument::OPTIONAL, 'remove Not Found Options');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var RouterService $service */
        $service = $this->getContainer()->get('mjrone.codegenerator.router')->setOutput($output);
        $service->setCleanup($input->getArgument('cleanup')!==null);
        /** @var CodeGeneratorInterface $service */
        $service->setInput($input)->process();
    }
}
