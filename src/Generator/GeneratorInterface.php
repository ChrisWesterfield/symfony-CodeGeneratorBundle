<?php
declare(strict_types=1);
namespace MjrOne\CodeGeneratorBundle\Generator;

/**
 * Interface GeneratorInterface
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface GeneratorInterface
{
    const FILE_EXTENSION            = 'Extension';
    const FILE_CONFIGURATION        = 'Configuration';
    const FILE_TEST                 = 'Test';
    const FILE_EXTENSION_PHP        = '.php';
    const FILE_EXTENSION_TWIG       = '.twig';
    const FILE_COMPOSER             = 'composer.json';
    const FILE_README               = 'README.md';
    const FILE_CHANGELOG            = 'CHANGELOG.md';
    const FILE_LICENSE              = 'license';
    const FILE_EXTENSION_CONTROLLER = 'Controller';
    const DIRECTORY_COMMAND         = 'Command';
    const DIRECTORY_CONTROLLER      = 'Controller';
    const DIRECTORY_TESTS           = 'Tests';
    const DIRECTORY_SRC             = 'src';

    /**
     * @return string
     */
    public function getProjectRootDirectory(): string;
}
