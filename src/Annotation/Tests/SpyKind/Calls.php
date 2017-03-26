<?php

namespace MjrOne\CodeGenerator\Annotation\SpyKind;

use MjrOne\CodeGenerator\Annotation\Expression\Method;

/**
 * @Annotation
 * @Target({"ANNOTATION"})
 *
 * @author kko
 */
final class Calls implements \MjrOne\CodeGenerator\Annotation\SpyKind
{
    /**
     * @var int
     */
    public $nr;
    /**
     * @var \MjrOne\CodeGenerator\Annotation\Expression\Method
     */
    public $method;
}
