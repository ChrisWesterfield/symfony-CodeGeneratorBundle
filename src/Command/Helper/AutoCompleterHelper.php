<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class AutoCompleterHelper
 *
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class AutoCompleterHelper
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * AutoCompleterHelper constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     * @throws ORMException
     */
    public function getSuggestions()
    {
        $configuration = $this->getEm()->getConfiguration();
        $namespaceReplacements = array();
        foreach ($configuration->getEntityNamespaces() as $alias => $namespace)
        {
            $namespaceReplacements[$namespace . '\\'] = $alias . ':';
        }
        $entities = $configuration->getMetadataDriverImpl()->getAllClassNames();

        return array_map(
            function ($entity) use ($namespaceReplacements)
            {
                return strtr($entity, $namespaceReplacements);
            },
            $entities
        );
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEm(): EntityManagerInterface
    {
        return $this->em;
    }
}
