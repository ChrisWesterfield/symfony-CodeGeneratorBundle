<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Services\CodeGeneratorInterface;
use MjrOne\CodeGeneratorBundle\Services\RouterService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class GenerateRoutingCommand
 *
 * @package   MjrOne\CodeGeneratorBundle\Command
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
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
        $service->setCleanup($input->getArgument('cleanup') !== null);
        /** @var CodeGeneratorInterface $service */
        $service->setInput($input)->process();
    }
}
