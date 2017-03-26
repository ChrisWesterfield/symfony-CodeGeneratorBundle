<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"METHOD"})
*
* @author kko
*/
final class SpiesStore
{
    /**
     * One or more Mock annotations.
     *
     * @var mixed \MjrOne\CodeGenerator\Annotation\Spy[]
     */
    public $items = [];
}
