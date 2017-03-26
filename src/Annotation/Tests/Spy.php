<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class Spy
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var mixed \MjrOne\CodeGenerator\Annotation\SpyKind
     */
    public $expected;
    /**
     * @var bool
     */
    public $enabled = true;
}
