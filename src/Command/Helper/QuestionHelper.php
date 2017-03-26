<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command\Helper;

use Closure;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\Console\Helper\QuestionHelper as CoreQuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class QuestionHelper
 *
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class QuestionHelper extends CoreQuestionHelper
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param                                                   $errors
     *
     * @return void
     */
    public function printOperationSummary(OutputInterface $output, $errors): void
    {
        if (!$errors)
        {
            $this->printSection($output, 'Everything is OK! Now get to work :).');
        }
        else
        {
            $this->printSection(
                $output,
                [
                    'The Command was not able to Generate all Configurations. You\'ll need to make the following changes manually:',
                ],
                'error'
            );
            $output->writeln($errors);
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param                                                   $errors
     *
     * @return \Closure
     */
    public function getRunner(OutputInterface $output, &$errors): Closure
    {
        $runner = function ($err) use ($output, &$errors)
        {
            if ($err)
            {
                $output->writeln('<fg=red>FAILED</>');
                $errors = array_merge($errors, $err);
            }
            else
            {
                $output->writeln('<info>OK</info>');
            }
        };

        return $runner;
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param                                                   $text
     * @param string                                            $style
     *
     * @return void
     */
    public function printSection(OutputInterface $output, $text, $style = 'bg=blue;fg=white'): void
    {
        $output->writeln(
            [
                '',
                $this->getHelperSet()->get('formatter')->formatBlock($text, $style, true),
                '',
            ]
        );
    }

    /**
     * @param        $question
     * @param        $default
     * @param string $sep
     *
     * @return string
     */
    public function getQuestion($question, $default, $sep = ':'): string
    {
        return $default
            ? sprintf('<info>%s</info> [<comment>%s</comment>]%s ', $question, $default, $sep)
            : sprintf(
                '<info>%s</info>%s ', $question, $sep
            );
    }
}
