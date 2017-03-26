<?php

namespace Kassko\Test\UnitTestsGenerator;

use MjrOne\CodeGenerator\PhpUnitAbstractPhpGenerator;
use MjrOne\CodeGenerator\PhpUnitFaker;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Class_;
use MjrOne\CodeGenerator\PhpUnitOutputNamespaceResolver;
use MjrOne\CodeGenerator\PhpUnitUtil\ClassNameParser;
use MjrOne\CodeGenerator\PhpUnitUtil\Reflector;
use ReflectionClass;

/**
 * AbstractTestGenerator
 */
abstract class AbstractTestGenerator
{
    /**
     * @var array
     */
    protected $config;
    /**
     * @var AbstractPhpGenerator
     */
    protected $phpGenerator;
    /**
     * @var Reflector
     */
    protected $reflector;
    /**
     * @var Faker
     */
    protected $faker;
    /**
     * @var OutputNamespaceResolver
     */
    protected $outputNamespaceResolver;
    /**
     * @var ClassNameParser
     */
    protected $classNameParser;

    /**
     * @param array             $config
     * @param AbstractPhpGenerator      $phpGenerator
     * @param Reflector         $reflector
     * @param Faker             $faker
     * @param OutputNamespaceResolver $outputNamespaceResolver
     * @param ClassNameParser   $classNameParser
     */
    public function __construct(
        array $config,
        AbstractPhpGenerator $phpGenerator,
        Reflector $reflector,
        Faker $faker,
        OutputNamespaceResolver $outputNamespaceResolver,
        ClassNameParser $classNameParser
    ) {
        $this->config = $config;
        $this->phpGenerator = $phpGenerator;
        $this->reflector = $reflector;
        $this->faker = $faker;
        $this->outputNamespaceResolver = $outputNamespaceResolver;
        $this->classNameParser = $classNameParser;
    }

    /**
     * @param Class_ $classModel
     *
     * @return string
     */
    abstract public function generateCodeFromCodeModel(Class_ $classModel);
}
