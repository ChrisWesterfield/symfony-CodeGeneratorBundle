<?php

namespace Kassko\Test\UnitTestsGenerator;

use MjrOne\CodeGenerator\PhpUnitPlanLoader\ArrayLoader;
use MjrOne\CodeGenerator\PhpUnitPlanModel;
use Symfony\Component\Config\Definition\Processor;

/**
 * AbstractPlanLoader
 */
abstract class AbstractPlanLoader implements PlanLoader
{
    /**
     * @var ArrayLoader
     */
    private $arrayLoader;

    /**
     * @param ArrayLoader   $arrayLoader
     */
    public function __construct( ArrayLoader $arrayLoader)
    {
        $this->arrayLoader = $arrayLoader;
    }

    /**
     * @{inheritdoc}
     */
    public function load(PlanModel\Class_ $classPlanModel, PlanProviderResource $providerResource)
    {
        $data = $this->filterDataRecursively($this->getData($providerResource), [$this, 'isUsefullConfigEntry']);
        //$data = $this->getData($providerResource);

        if (stripos($providerResource->getResource(), 'manager')) {
            var_dump($data);
        }

        $data = $this->getValidatedData([$data]);

        return $this->arrayLoader->load($classPlanModel, new PlanProviderResource('array', $data));
    }

    /**
     * @param PlanProviderResource $providerResource
     * @return array
     */
    abstract protected function getData(PlanProviderResource $providerResource);

    /**
     * @param $data
     * @param callable $callback (default|null)
     *
     * @return array
     */
    protected function filterDataRecursively(array $data, callable $callback = null)
    {
        foreach ($data as &$value) {
            if (is_array($value)) {
                $value = $this->filterDataRecursively($value, $callback);
            }
        }

        return array_filter($data, $callback);
    }

    /**
     * @param mixed $entry
     *
     * @return bool
     */
    protected function isUsefullConfigEntry($entry)
    {
        return is_array($entry) ? count($entry) : null !== $entry;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getValidatedData(array $data)
    {
        $processor = new Processor();
        $planDataValidator = new PlanDataValidator();

        return $processor->processConfiguration(
            $planDataValidator,
            $data
        );
    }
}
