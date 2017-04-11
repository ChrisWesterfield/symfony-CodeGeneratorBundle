<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\EventListener;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\DebugBundle\DataCollector\XhprofCollector;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommandListener
 * @package MjrOne\CodeGeneratorBundle\EventListener
 * @author Christopher Westerfield <chris.westerfield@spectware.com>
 * @link https://www.spectware.com
 * @copyright Spectware, Inc.
 * @license SpectwarePro Source License
 * @CG\Service\Injection(container=true)
 */
class CommandListener
{
    /**
     * @var XhprofCollector
     * @CG\Service\Property(service="")
     */
    private $collector;

    /**
     * @CG\Service\Property(service="%spectware_library_profiler.command_option_name%")
     */
    public $optionName;

    /**
     * @var string
     * @CG\Service\Property(service="%mjr_profiler.command%")
     */
    public $mode;

    /**
     * @var array
     * @CG\Service\Property(service="%mjr_profiler.command_exclude_patterns%")
     */
    public $filters = array();

    /**
     * @DI\Inject("%mjr_profiler.location_web%",required=false)
     */
    public $webLocation;


    /**
     * @param string $mode on|off|option
     */
    public function setEnabled($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @param string $option name of the cli option for enabled mode "option"
     */
    public function setOptionName($option)
    {
        $this->optionName = $option;
    }

    /**
     * @param array $excludes List of regular expressions for command names to exclude
     */
    public function setFilters(array $excludes)
    {
        $this->filters = $excludes;
    }

    /**
     * Configure the base url to the xhprof web gui.
     *
     * @param string $webLocation
     */
    public function setWebLocation($webLocation)
    {
        $this->webLocation = $webLocation;
    }

    /**
     * We need to add the profile enable option to all commands if we are in
     * the parameter mode.
     *
     * Inspired by
     * http://php-and-symfony.matthiasnoback.nl/2013/11/symfony2-add-a-global-option-to-console-commands-and-generate-pid-file/
     *
     * @param ConsoleCommandEvent $event
     * @return mixed
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    private function isProfileOption(ConsoleCommandEvent $event)
    {
        $inputDefinition = $event->getCommand()->getApplication()->getDefinition();

        $inputDefinition->addOption(
            new InputOption($this->optionName, null, InputOption::VALUE_NONE, '<info>MJRProfilerBundle</info>: Whether to profile this command with xhprof', null)
        );

        // merge the application's input definition
        $event->getCommand()->mergeApplicationDefinition();

        $input = new ArgvInput();

        // we use the input definition of the command
        $input->bind($event->getCommand()->getDefinition());
        return $input->getParameterOption($this->optionName);
    }

    /**
     * Start the profiler if
     * - we are not running the list or help command
     * - the command mode is on
     * - or the command mode if option and the option is specified
     *
     * @param ConsoleCommandEvent $event
     */
    public function onCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand()->getName();
        $system = array(
            'list',
            'help',
            'assetic:dump',
            'assets:install',
            'config:dump-reference',
            'container:debug',
            'router:debug',
            'cache:clear',
            'cache:warmup',
            'cache:create-cache-class',
        );
        if (in_array($command, $system)) {
            return;
        }
        if (
            'off' == $this->mode
            ||
            (
                'option' == $this->mode
                &&
                !$this->isProfileOption($event)
            )
        )
        {
            return;
        }

        foreach ($this->filters as $exclude) {
            if (preg_match('@' . $exclude . '@', $command)) {
                return;
            }
        }


        if ($this->collector->startProfiling()) {
            $event->getOutput()->writeln("XHProf starting run\n---");
        }
    }

    /**
     * Trigger the collector to end the request and output the xhprof link if
     * we where collecting.
     *
     * @param ConsoleTerminateEvent $event
     */
    public function onTerminate(ConsoleTerminateEvent $event)
    {
        $command = $event->getCommand();
        $link = $this->collector->stopProfiling('cli', $command->getName());
        if (false === $link) {
            return;
        }


        $event->getOutput()->writeln(sprintf(
            "\n---\nXHProf run link <info>%s</info>",
            $this->collector->getXhprofUrl()
        ));
    }

}