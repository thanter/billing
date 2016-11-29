<?php


use App\PlanConfig;

function plan($entity = null, $key = null) {

    $planConfigurator = resolve(PlanConfig::class);

    if (func_num_args() === 0) {
        return $planConfigurator;
    }


    // If entity matches the name of a plan
    // return this plan
    if (array_key_exists($entity, config('plans.available'))) {

        $plan = $planConfigurator->getPlan($entity);

        if (!is_null($key)) {
            return $plan->getAttribute($key);
        }

        return $plan;
    }

    // If entity is just a string, retrieve current user's plan
    // and get the value for this string
    return $planConfigurator->userPlan()->getAttribute($entity);
}