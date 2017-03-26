<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"METHOD"})
*
* @author kko
*/
final class MocksStore
{
    /**
     * One or more Mock annotations.
     *
     * @var array<\MjrOne\CodeGenerator\Annotation\Mock>
     */
    public $items = [];
}
