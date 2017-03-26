<?php

namespace MjrOne\CodeGenerator\Annotation\Expression;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class Mocks implements \MjrOne\CodeGenerator\Annotation\Expression
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
