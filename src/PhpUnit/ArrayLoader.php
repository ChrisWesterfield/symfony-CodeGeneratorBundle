<?php

namespace MjrOne\CodeGenerator\PhpUnitPlanLoader;

use MjrOne\CodeGenerator\PhpUnitPlanModel;
use MjrOne\CodeGenerator\PhpUnitPlanProviderResource;

/**
 * ArrayLoader
 */
class ArrayLoader implements \MjrOne\CodeGenerator\PhpUnitPlanLoader
{
    /**
     * {@inheritdoc}
     */
    public function supports(PlanProviderResource $providerResource)
    {
        return 'array' === $providerResource->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function load(PlanModel\Class_ $classPlanModel, PlanProviderResource $providerResource)
    {
        $data = $providerResource->getResource();

        /** Here load plan model from data */

        return $classPlanModel;
    }
}
