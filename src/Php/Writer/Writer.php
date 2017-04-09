<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Writer;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\DocumentInterface;
use MjrOne\CodeGeneratorBundle\Php\Document\File;
use Symfony\Component\Filesystem\Filesystem;
use Twig_Environment;

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
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Writer constructor.
     *
     * @param Twig_Environment $twig_Environment
     */
    public function __construct(Twig_Environment $twig_Environment)
    {
        $this->twig = $twig_Environment;
    }

    /**
     * @param DocumentInterface|File $document
     * @param $file
     */
    public function writeDocument(DocumentInterface $document, $file)
    {
        $data = [
            'file'       => $document,
            'methods'    => $document->getMethods(),
            'properties' => $document->getProperties(),
            'constants'  => $document->getConstants(),
        ];
        $output = $this->twig->render('MjrOneCodeGeneratorBundle:Writer:base.php.twig',$data);
        $fs = new Filesystem();
        $fs->dumpFile($file, $output);
    }
}
