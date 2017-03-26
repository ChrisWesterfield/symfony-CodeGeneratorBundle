<?php

namespace Kassko\Test\UnitTestsGenerator;

use MjrOne\CodeGenerator\PhpUnitPlanModel;

/**
 * PlanLoader
 */
interface PlanLoader
{
    /**
     * @param PlanProviderResource $providerResource
     */
    public function supports(PlanProviderResource $providerResource);
    /**
     * @param PlanModel\Class_ 		$classPlanModel
     * @param PlanProviderResource 	$providerResource
     *
     * @return PlanModel\Class_
     */
    public function load(PlanModel\Class_ $classPlanModel, PlanProviderResource $providerResource);
}
