<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class Spies
{
    /**
     * @var array
     */
    public $items;

    public function __construct(array $data)
    {
        $this->items = $data;
    }
}
