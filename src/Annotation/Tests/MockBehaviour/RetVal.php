<?php

namespace MjrOne\CodeGenerator\Annotation\MockBehaviour;

/**
* @Annotation
* @Target({"ANNOTATION"})
*
* @author kko
*/
final class RetVal implements \MjrOne\CodeGenerator\Annotation\MockBehaviour
{
    /**
     * @var mixed
     */
    public $val;

    public function __construct(array $data)
    {
        $this->val = current($data);
    }
}
