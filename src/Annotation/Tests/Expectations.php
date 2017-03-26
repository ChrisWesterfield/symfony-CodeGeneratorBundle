<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"METHOD"})
*
* @author kko
*/
final class Expectations
{
    /**
     * @var array<\MjrOne\CodeGenerator\Annotation\Expectation>
     */
    public $items = [];
}
