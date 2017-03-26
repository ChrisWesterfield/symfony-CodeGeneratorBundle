<?php

namespace MjrOne\CodeGenerator\Annotation\SpyKind;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class Exception_ implements \MjrOne\CodeGenerator\Annotation\SpyKind
{
    /**
     * @var string
     */
    public $class;
    /**
     * @var integer
     */
    public $code;
    /**
     * @var string
     */
    public $message;
}
