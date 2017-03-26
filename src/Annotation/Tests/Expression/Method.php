<?php

namespace MjrOne\CodeGenerator\Annotation\Expression;

/**
 * @Annotation
 * @Target({"ANNOTATION"})
 *
 * @author kko
 */
final class Method implements \MjrOne\CodeGenerator\Annotation\Expression
{
    /**
     * @var string
     */
    public $obj;
    /**
     * @var string
     */
    public $func;
    /**
     * @var bool
     */
    public $member;
}
