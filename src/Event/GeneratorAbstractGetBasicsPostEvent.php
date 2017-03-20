<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:06
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface;

class GeneratorAbstractGetBasicsPostEvent extends EventAbstract
{
    /**
     * @var array
     */
    protected $fileBasics;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Document\Annotation
     */
    protected $documentAnnotation;

    public function __construct(GeneratorInterface $subject,array $fileBasics, Annotation $doc)
    {
        parent::__construct($subject);
        $this->fileBasics = $fileBasics;
        $this->documentAnnotation = $doc;
    }

    /**
     * @return array
     */
    public function getFileBasics(): array
    {
        return $this->fileBasics;
    }

    /**
     * @param array $fileBasics
     *
     * @return GeneratorAbstractGetBasicsPostEvent
     */
    public function setFileBasics(array $fileBasics): GeneratorAbstractGetBasicsPostEvent
    {
        $this->fileBasics = $fileBasics;

        return $this;
    }
}
