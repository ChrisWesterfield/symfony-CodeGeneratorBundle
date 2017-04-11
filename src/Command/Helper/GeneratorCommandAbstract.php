<?php
declare(strict_types=1);
/**
 * @author    Christopher Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield, Mjr.One
 * @license   LGPL V3
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 25/03/2017
 * Time: 11:36
 */

namespace MjrOne\CodeGeneratorBundle\Command\Helper;

use Doctrine\Bundle\DoctrineBundle\Mapping\DisconnectedMetadataFactory;
use InvalidArgumentException;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\Generator;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use MjrOne\CodeGeneratorBundle\Command\Helper\QuestionHelper;

/**
 * Class GeneratorCommandAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
abstract class GeneratorCommandAbstract extends ContainerAwareCommand
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @param Generator $generator
     */
    public function setGenerator( $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface
     */
    abstract protected function createGenerator(): CodeGeneratorInterface;

    /**
     * @param \Symfony\Component\HttpKernel\Bundle\BundleInterface|null $bundle
     *
     * @return \MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface
     */
    protected function getGenerator(BundleInterface $bundle = null): CodeGeneratorInterface
    {
        if (null === $this->generator)
        {
            $this->generator = $this->createGenerator();
            $this->generator->setSkeletonDirs($this->getSkeletonDirs($bundle));
        }

        return $this->generator;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Bundle\BundleInterface|null $bundle
     *
     * @return array
     */
    protected function getSkeletonDirs(BundleInterface $bundle = null)
    {
        $skeletonDirs = array();

        if (isset($bundle)
            && $this->generator->getFileSystem()->exists(
                $dir = $bundle->getPath() . '/Resources/MjrOneCodeGeneratorBundle/skeleton'
            )
        )
        {
            $skeletonDirs[] = $dir;
        }

        if ($this->generator->getFileSystem()->exists(
            $dir = $this->getContainer()->get('kernel')->getRootDir() . '/Resources/MjrOneCodeGeneratorBundle/skeleton'
        )
        )
        {
            $skeletonDirs[] = $dir;
        }

        $skeletonDirs[] = __DIR__ . '/../Resources/skeleton';
        $skeletonDirs[] = __DIR__ . '/../Resources';

        return $skeletonDirs;
    }

    /**
     * @return QuestionHelper
     */
    protected function getQuestionHelper()
    {
        $question = $this->getHelperSet()->get('question');
        if (!$question || get_class($question) !== QuestionHelper::class)
        {
            $this->getHelperSet()->set($question = new QuestionHelper());
        }

        return $question;
    }

    /**
     * @param string $absolutePath
     *
     * @return string
     * @throws \LogicException
     */
    protected function makePathRelative($absolutePath): string
    {
        $projectRootDir = $this->createGenerator()->getProjectRootDirectory();

        return str_replace($projectRootDir . '/', '', realpath($absolutePath) ? : $absolutePath);
    }

    /**
     * @param $shortcut
     *
     * @return array
     * @throws InvalidArgumentException
     */
    protected function parseShortcutNotation($shortcut): array
    {
        $entity = str_replace('/', '\\', $shortcut);

        if (false === $pos = strpos($entity, ':'))
        {
            throw new InvalidArgumentException(
                sprintf(
                    'The entity name must contain a : ("%s" given, expecting something like AcmeBlogBundle:Blog/Post)',
                    $entity
                )
            );
        }

        return array(substr($entity, 0, $pos), substr($entity, $pos + 1));
    }

    /**
     * @param $entity
     *
     * @return array
     * @throws \LogicException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    protected function getEntityMetadata($entity): array
    {
        $factory = new DisconnectedMetadataFactory($this->getContainer()->get('doctrine'));

        return $factory->getClassMetadata($entity)->getMetadata();
    }
}
