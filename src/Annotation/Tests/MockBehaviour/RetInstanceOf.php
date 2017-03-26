<?php

namespace MjrOne\CodeGenerator\Annotation\MockBehaviour;

/**
 * @Annotation
 * @Target({"ANNOTATION"})
 *
 * @author kko
 */
final class RetInstanceOf implements \MjrOne\CodeGenerator\Annotation\MockBehaviour
{
    /**
     * @var string
     */
    public $class;

    public function __construct(array $data)
    {
        $this->class = current($data);
    }
}
