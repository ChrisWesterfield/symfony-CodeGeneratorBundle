<?php

namespace Kassko\Test\UnitTestsGenerator;

use MjrOne\CodeGenerator\PhpUnitCodeModel\Class_;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Expression\NewAssign;

/**
 * NamespacesCollectorVisitor
 */
class NamespacesCollectorVisitor
{
    /**
     * @var array
     */
    private $usedNamespaces = [];

    /**
     * @return array
     */
    public function getUsedNamespaces()
    {
        sort($this->usedNamespaces);

        return $this->usedNamespaces;
    }

    /**
     * @param Class_ $classModel
     */
    public function visit(Class_ $classModel)
    {
        $this->collectNamespaces($classModel->getInitStatements());

        foreach ($classModel->getMethods() as $method) {
            $this->collectNamespaces($method->getInitStatements());
        }
    }

    /**
     * @param Statement[] $statements
     */
    protected function collectNamespaces(array $statements)
    {
        foreach ($statements as $statement) {
            $newAssign = $statement->getExpression();
            if (!$newAssign instanceof NewAssign) {
                continue;
            }
            $fullClass = $newAssign->getFullClass();
            $this->usedNamespaces[$fullClass] = $fullClass;
        }
    }
}
