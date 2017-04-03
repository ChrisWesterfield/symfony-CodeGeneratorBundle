<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Bundle;
use Symfony\Component\Finder\Finder;

/**
 * Class BundleGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class BundleGenerator extends GeneratorDriverAbstract
{

    const BUNDLE_TWIG_NAMESPACE = 'MjrOneCodeGeneratorBundle:Bundle:';

    /**
     * @param \MjrOne\CodeGeneratorBundle\Document\Bundle $bundle
     *
     * @throws \RuntimeException
     */
    public function generateBundle(Bundle $bundle)
    {
        $dir = $bundle->getTargetDirectory();
        $sourceDirectory = '';
        if ($bundle->isCreateSource())
        {
            $sourceDirectory = '/src';
        }
        if ($this->getFileSystem()->exists($dir))
        {
            if (!is_dir($dir))
            {
                throw new \RuntimeException(
                    sprintf(
                        'Unable to generate the bundle as the target directory "%s" exists but is a file.',
                        realpath($dir)
                    )
                );
            }
            $finder = (new Finder())->files()->in($dir);
            if ($finder->files()->count() > 0)
            {
                throw new \RuntimeException(
                    sprintf('Unable to generate the bundle as the target directory "%s" is not empty.', realpath($dir))
                );
            }
            if (!is_writable($dir))
            {
                throw new \RuntimeException(
                    sprintf(
                        'Unable to generate the bundle as the target directory "%s" is not writable.', realpath($dir)
                    )
                );
            }
        }

        $parameters = array(
            'namespace'       => $bundle->getNameSpace(),
            'bundle'          => $bundle->getName(),
            'format'          => $bundle->getConfigurationFormat(),
            'bundle_basename' => $bundle->getBasename(),
            'extension_alias' => $bundle->getExtensionAlias(),
            'configuration'   => $this->getConfiguration()->toArray(),
            'useRouter'       => $bundle->isUseRouteUpdates(),
        );

        $this->renderFile(
            self::BUNDLE_TWIG_NAMESPACE . 'bundle.php.twig',
            $dir . $sourceDirectory . '/'  . $bundle->getName() . self::FILE_EXTENSION_PHP,
            $parameters
        );

        $this->renderFile(
            self::BUNDLE_TWIG_NAMESPACE . 'bundleTest.php.twig',
            $bundle->getTestsDirectory() . '/' . $bundle->getName() . self::FILE_TEST . self::FILE_EXTENSION_PHP,
            $parameters
        );

        if ($bundle->shouldGenerateDependencyInjectionDirectory())
        {
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'extension.php.twig',
                $dir . $sourceDirectory . '/'  . '/DependencyInjection/' . $bundle->getBasename() . self::FILE_EXTENSION
                . self::FILE_EXTENSION_PHP,
                $parameters
            );
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'extensionTest.php.twig',
                $bundle->getTestsDirectory() . '/DependencyInjection/' . $bundle->getBasename() . self::FILE_EXTENSION
                . self::FILE_TEST . self::FILE_EXTENSION_PHP,
                $parameters
            );
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'configuration.php.twig',
                $dir . $sourceDirectory . '/'  . '/DependencyInjection/' . self::FILE_CONFIGURATION . self::FILE_EXTENSION_PHP,
                $parameters
            );
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'configurationTest.php.twig',
                $bundle->getTestsDirectory() . '/DependencyInjection/' . self::FILE_CONFIGURATION . self::FILE_TEST
                . self::FILE_EXTENSION_PHP,
                $parameters
            );
        }

        if ($bundle->isCreateDefaultController())
        {
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'defaultController.php.twig',
                $dir . $sourceDirectory . '/'  . '/Controller/DefaultController' . self::FILE_EXTENSION_PHP,
                $parameters
            );
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'defaultControllerTest.php.twig',
                $bundle->getTestsDirectory() . '/Controller/DefaultController' . self::FILE_TEST
                . self::FILE_EXTENSION_PHP,
                $parameters
            );
            $this->renderFile(
                self::BUNDLE_TWIG_NAMESPACE . 'index.html.twig.twig',
                $dir . $sourceDirectory . '/'  . '/Resources/views/Default/index.html' . self::FILE_EXTENSION_TWIG,
                $parameters
            );
        }
        // render the services.yml/xml file
        $servicesFilename = $bundle->getServicesConfigurationFilename();
        $this->renderFile(
            sprintf(self::BUNDLE_TWIG_NAMESPACE . '%s.twig', $servicesFilename),
            $dir . $sourceDirectory . '/'  . '/Resources/config/' . $servicesFilename,
            $parameters
        );

        if ($routingFilename = $bundle->getRoutingConfigurationFilename())
        {
            $this->renderFile(
                sprintf(self::BUNDLE_TWIG_NAMESPACE . '%s.twig', $routingFilename),
                $dir . $sourceDirectory . '/'  . '/Resources/config/' . $routingFilename,
                $parameters
            );
        }

        if ($bundle->isCreateComposer())
        {
            $name = $bundle->getNameSpace();
            $nameSep = explode('\\', $name);
            $nameString = '';
            foreach ($nameSep as $id => $item)
            {
                $nameSep[$id] = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $item));
            }
            $nameString = implode('/', $nameSep);
            $composer = [
                'authors'     => $this->configuration->getFileProperties()->getAuthors()->toArray(),
                'autoload'    => [
                    'psr-4' => [
                        str_replace('\\', '\\\\', $bundle->getNameSpace()) . '\\\\'      => ($bundle->isCreateSource()
                                                                                             === true) ? 'src/' : '/',
                        str_replace('\\', '\\\\', $bundle->getNameSpace() . '\\Tests\\') => 'Tests/',
                    ],
                ],
                'description' => '',
                'extra'       => [
                    'branch-alias' => [
                        'release' => 'master',
                    ],
                ],
                'homepage'    => $this->configuration->getFileProperties()->getLink(),
                'keywords'    => [],
                'license'     => $this->configuration->getFileProperties()->getLicense(),
                'name'        => $nameString,
                'type'        => 'symfony-bundle',
                'version'     => '1.0.0',
            ];
            $composerString = json_encode($composer, JSON_PRETTY_PRINT);
            $composerString = str_replace(['\\\\', '\/'], ['\\', '/'], $composerString);
            $this->getFileSystem()->dumpFile($dir . '/' . self::FILE_COMPOSER, $composerString);
        }
        $this->getFileSystem()->dumpFile($dir . '/' . self::FILE_README, "** README **\n\n\n");
        $this->getFileSystem()->dumpFile(
            $dir . '/' . self::FILE_CHANGELOG, "** CHANGELOG **\n\n1.0.0\nInitialCommit\n\n"
        );
        $this->getFileSystem()->dumpFile($dir . '/' . self::FILE_LICENSE, "\n\n\n");
    }
}
