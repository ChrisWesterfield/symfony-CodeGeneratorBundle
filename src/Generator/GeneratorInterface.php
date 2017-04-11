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
    public const FILE_EXTENSION            = 'Extension';
    public const FILE_CONFIGURATION        = 'Configuration';
    public const FILE_TEST                 = 'Test';
    public const FILE_EXTENSION_PHP        = '.php';
    public const FILE_EXTENSION_TWIG       = '.twig';
    public const FILE_COMPOSER             = 'composer.json';
    public const FILE_README               = 'README.md';
    public const FILE_CHANGELOG            = 'CHANGELOG.md';
    public const FILE_LICENSE              = 'license';
    public const FILE_EXTENSION_CONTROLLER = 'Controller';
    public const DIRECTORY_COMMAND         = 'Command';
    public const DIRECTORY_CONTROLLER      = 'Controller';
    public const DIRECTORY_TESTS           = 'Tests';
    public const DIRECTORY_SRC             = 'src';

    /**
     * @return string
     */
    public function getProjectRootDirectory(): string;
}
