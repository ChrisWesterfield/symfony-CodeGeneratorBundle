<?php

namespace MjrOne\CodeGenerator\Annotation\Expression;

/**
 * @Annotation
 * @Target({"ANNOTATION"})
 *
 * @author kko
 */
final class OppositeMockOf implements \MjrOne\CodeGenerator\Annotation\Expression
{
    /**
     * @var string
     */
    public $id;

    public function __construct(array $data)
    {
        $this->id = current($data);
    }
}
