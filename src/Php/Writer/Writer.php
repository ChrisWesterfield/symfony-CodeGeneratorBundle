<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Writer;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\DocumentInterface;
use MjrOne\CodeGeneratorBundle\Php\Document\File;
use MjrOne\CodeGeneratorBundle\Php\Document\Constants;
use MjrOne\CodeGeneratorBundle\Php\Document\Method;
use MjrOne\CodeGeneratorBundle\Php\Document\Property;

/**
 * Class Writer
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Writer
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class Writer
{
    /**
     * @param DocumentInterface|File $document
     */
    public function writeDocument(DocumentInterface $document)
    {
        if ($document->isUpdateNeeded())
        {
            $prepared = [
                'constants'  => '',
                'properties' => '',
                'methods'    => '',
            ];
            $prepared['constants'] = $this->prepareConstants($document->getConstants());
            $prepared['properties'] = $this->prepareProperties($document->getProperties());
            $prepared['methods'] = $this->prepareMethods($document->getMethods());
            $documentString = $this->prepareFile($document, $prepared);
            $this->saveDocument($document, $documentString);
        }
    }

    /**
     * @param DocumentInterface[]|Constants[] $constants
     *
     * @return string
     */
    protected function prepareConstants(array $constants): string
    {
        $outputString = '';
        if(!empty($constants))
        {
            foreach($constants as $constant)
            {
                $outputString .= '    '.$constant->getVisibility().' '.$constant->getName().' = '.$constant->getValue().';'."\n";
            }
        }
        return $outputString;
    }

    /**
     * @param DocumentInterface[]|Property[] $properties
     *
     * @return string
     */
    protected function prepareProperties(array $properties): string
    {
        $outputString = '';
        if(!empty($properties))
        {
            foreach($properties as $property)
            {
                if($property->hasComment())
                {
                    $outputString .= implode("\n",$property->getComment())."\n\n";
                }
                $outputString .= '    '.$property->getVisibility().' $'.$property->getName().($property->hasDefaultValue()?' = '.$property->getDefaultValue():'').';'."\n";
            }
        }
        return $outputString;
    }

    /**
     * @param DocumentInterface[]|Method[] $methods
     *
     * @return string
     */
    protected function prepareMethods(array $methods): string
    {
        $outputString = '';
        if(!empty($methods))
        {
            foreach($methods as $method)
            {
                if($method->hasComment())
                {
                    $outputString .= implode("\n",$method->getComment());
                    $outputString .= "\n";
                }
                $outputString .= '    '.$method->getVisibility().' function '.$method->getName().'( ';
                if(!$method->hasVariables())
                {
                    foreach($method->getVariables() as $variable)
                    {
                        $outputString .= (!$variable->getType()!==false?$variable->getType()).' $'.$variable->getName().($variable->hasDefaultValue()?' = '.$variable->getDefaultValue():'');
                    }
                }
                $outputString .= ')'."\n".'    {'."\n".$method->getBody()."\n    }"."\n\n";
            }
        }
        return $outputString;
    }

    /**
     * @param DocumentInterface $document
     * @param array             $prepared
     *
     * @return string
     */
    protected function prepareFile(DocumentInterface $document, array $prepared): string
    {
        $outputString = '';

        return $outputString;
    }

    /**
     * @param DocumentInterface $document
     * @param string            $documentString
     */
    protected function saveDocument(DocumentInterface $document, string $documentString): void
    {

    }
}
