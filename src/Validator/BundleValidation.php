<?php
declare(strict_types=1);
namespace MjrOne\CodeGeneratorBundle\Validator;

use InvalidArgumentException;
use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class BundleValidation
 *
 * @package MjrOne\CodeGeneratorBundle\Validator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class BundleValidation
{
    const RESRVED_WORDS        = [
        'abstract', 'and', 'array', 'as', 'break', 'callable',
        'case', 'catch', 'class', 'clone', 'const', 'continue',
        'declare', 'default', 'do', 'else', 'elseif', 'enddeclare',
        'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'extends',
        'final', 'finally', 'for', 'foreach', 'function', 'global',
        'goto', 'if', 'implements', 'interface', 'instanceof', 'insteadof',
        'namespace', 'new', 'or', 'private', 'protected', 'public',
        'static', 'switch', 'throw', 'trait', 'try', 'use',
        'var', 'while', 'xor', 'yield', '__CLASS__', '__DIR__',
        '__FILE__', '__LINE__', '__FUNCTION__', '__METHOD__', '__NAMESPACE__', '__TRAIT__',
        '__halt_compiler', 'die', 'echo', 'empty', 'exit', 'eval',
        'include', 'include_once', 'isset', 'list', 'require', 'require_once',
        'return', 'print', 'unset',
    ];
    const FORMAT_YAML          = 'yaml';
    const FORMAT_YML           = 'yml';
    const FORMAT_PHP           = 'php';
    const FORMAT_XML           = 'xml';
    const FORMAT_ANO           = 'annotation';
    const FORMAT               = [
        self::FORMAT_PHP,
        self::FORMAT_XML,
        self::FORMAT_YML,
        self::FORMAT_ANO,
    ];
    const REGEX_ENITY_NAME     = '{^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*:[a-zA-Z0-9_\x7f-\xff\\\/]+$}';
    const REGEX_BUNDLE_NAME    = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
    const REGEX_BUNDLE_POSTFIX = '/Bundle$/';
    const REGEX_BUNDLE_NAMESPACE = '/^(?:[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\\\?)+$/';

    /**
     * @param $entity
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function validateEntityName($entity)
    {
        if (!preg_match(self::REGEX_ENITY_NAME, $entity)) {
            throw new InvalidArgumentException(sprintf('The entity name isn\'t valid ("%s" given, expecting something like AcmeBlogBundle:Blog/Post)', $entity));
        }
        return $entity;
    }

    /**
     * @param $format
     *
     * @return string
     */
    public function validateFormat($format)
    {
        if (!$format)
        {
            throw new \RuntimeException('Please enter a configuration format.');
        }
        $format = strtolower($format);
        if ($format === self::FORMAT_YAML)
        {
            $format = self::FORMAT_YML;
        }
        if (!in_array($format, self::FORMAT))
        {
            throw new \RuntimeException(sprintf('Format "%s" is not supported.', $format));
        }
        return $format;
    }

    /**
     * @param $controller
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function validateControllerName($controller)
    {
        try
        {
            $this->validateEntityName($controller);
        }
            catch (InvalidArgumentException $e)
        {
            throw new InvalidArgumentException
            (
                sprintf
                (
                    'The controller name must contain a : ("%s" given, expecting something like FOOBUNDLE:Post)',
                    $controller
                )
            );
        }
        return $controller;
    }

    /**
     * @param $bundle
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function validateBundleName($bundle)
    {
        if (!preg_match(self::REGEX_BUNDLE_NAME, $bundle)) {
            throw new InvalidArgumentException(sprintf('The bundle name %s contains invalid characters.', $bundle));
        }
        if (!preg_match(self::REGEX_BUNDLE_POSTFIX, $bundle)) {
            throw new InvalidArgumentException('The bundle name must end with Bundle.');
        }
        return $bundle;
    }

    /**
     * @param      $namespace
     * @param bool $requireVendorNamespace
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function validateBundleNamespace($namespace, $requireVendorNamespace = true)
    {
        if (!preg_match('/Bundle$/', $namespace))
        {
            throw new InvalidArgumentException('The namespace must end with Bundle.');
        }
        $namespace = strtr($namespace, '/', '\\');
        if (!preg_match(self::REGEX_BUNDLE_NAMESPACE, $namespace))
        {
            throw new InvalidArgumentException('The namespace contains invalid characters.');
        }
        // validate reserved keywords
        foreach (explode('\\', $namespace) as $word)
        {
            if (in_array(strtolower($word), self::RESRVED_WORDS))
            {
                throw new InvalidArgumentException(sprintf('The namespace cannot contain PHP reserved words ("%s").', $word));
            }
        }
        // validate that the namespace is at least one level deep
        if ($requireVendorNamespace && false === strpos($namespace, '\\'))
        {
            $msg = array();
            $msg[] = sprintf('The namespace must contain a vendor namespace (e.g. "VendorName\%s" instead of simply "%s").', $namespace, $namespace);
            $msg[] = 'If you\'ve specified a vendor namespace, did you forget to surround it with quotes (init:bundle "Foo\BlogBundle")?';
            throw new InvalidArgumentException(implode("\n\n", $msg));
        }
        return $namespace;
    }
}
