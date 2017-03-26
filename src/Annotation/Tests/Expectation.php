<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class Expectation
{
    /**
     * @var mixed
     */
    public $return;
    /**
     * @var \MjrOne\CodeGenerator\Annotation\Mocks
     */
    public $mocks;
    /**
     * @var \MjrOne\CodeGenerator\Annotation\Spies
     */
    public $spies;
    /**
     * @var bool
     */
    public $enabled = true;
}
