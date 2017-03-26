<?php

namespace MjrOne\CodeGenerator\Annotation;

/**
* @Annotation
* @Target({"PROPERTY"})
*
* @author kko
*/
final class Type
{
    /**
     * @var string
     */
    public $val;

    public function __construct(array $data)
    {
        $this->value = current($data);
    }
}
