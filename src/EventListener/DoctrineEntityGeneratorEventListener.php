<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\EventListener;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\DoctrineEntityGeneratorContentEvent;

/**
 * Class DoctrineEntityGeneratorEventListener
 *
 * @package   MjrOne\CodeGeneratorBundle\EventListener
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class DoctrineEntityGeneratorEventListener
{
    /**
     * @param DoctrineEntityGeneratorContentEvent $event
     */
    public function onContentGenerationEvent(DoctrineEntityGeneratorContentEvent $event)
    {
        $addUseStatements = [];
        //1. Check if Gedmo is available
        if (class_exists('Gedmo\DoctrineExtensions'))
        {
            $addUseStatements[] = 'use Gedmo\Mapping\Annotation as Gedmo;';
        }
        $addUseStatements[] = 'use MjrOne\CodeGeneratorBundle\Annotation as CG;';
        $content = explode("\n", $event->getContent());
        $newContent = [];
        $namespace = false;
        $done = false;
        foreach ($content as $row)
        {
            $newContent[] = $row;
            if (strpos($row, 'namespace') !== false)
            {
                $namespace = true;
            }
            if (strpos($row, ' as ORM;') !== false && $namespace && !$done)
            {
                foreach($addUseStatements as $entry)
                {
                    $newContent[] = $entry;
                }
                $done = true;
            }
        }
        $event->setContent(implode("\n", $newContent));
    }
    /**
     * @param DoctrineEntityGeneratorContentEvent $event
     */
    public function onContentRepositoryGenerationEvent(DoctrineEntityGeneratorContentEvent $event)
    {
        $addUseStatements = [];
        $addUseStatements[] = 'use MjrOne\CodeGeneratorBundle\Annotation as CG;';
        $content = explode("\n", $event->getContent());
        $newContent = [];
        $done = false;
        foreach ($content as $row)
        {
            $newContent[] = $row;
            if (strpos($row, 'namespace') !== false && !$done)
            {
                foreach($addUseStatements as $entry)
                {
                    $newContent[] = $entry;
                }
                $done = true;
            }
        }
        $event->setContent(implode("\n", $newContent));
    }
}
