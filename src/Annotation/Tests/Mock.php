<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class Mock
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var mixed array<\MjrOne\CodeGenerator\Annotation\Expression>
     */
    public $expr;
    /**
     * @var mixed
     */
    public $behav;
    /**
     * @var mixed
     */
    public $return;
    /**
     * @var bool
     */
    public $enabled = true;
}
