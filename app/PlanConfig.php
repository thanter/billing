<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;
use Braintree\Exception\Authentication;
use Illuminate\Database\Eloquent\Collection;


class PlanConfig
{
    private $tiers;
    private $default;

    public function __construct()
    {
        $this->default = config('plans.default');
        $this->tiers = config('plans.tiers');
    }


    public function defaultPlansRaw()
    {
        return $this->default;
    }


    public function tiersRaw()
    {
        return $this->tiers;
    }


    public function allRaw()
    {
        return array_merge($this->defaultPlansRaw(), $this->tiersRaw());
    }


    public function defaultPlans()
    {
        $defaultPlans = new Collection;
        foreach ($this->defaultPlansRaw() as $plan) {
            $defaultPlans->add(
                $this->buildDefaultPlan($plan)
            );
        }

        return $defaultPlans;
    }


    public function tiers()
    {
        $tiers = new Collection;
        foreach ($this->tiersRaw() as $plan) {
            foreach ($plan['charge_modes'] as $duration => $info) {
                $tiers->add(
                    $this->buildTier($plan, $duration)
                );
            }
        }

        return $tiers;
    }


    public function all()
    {
        return $this->defaultPlans()->merge($this->tiers());
    }


    public function getPlanRaw($key)
    {
        if (! array_key_exists($key, $this->allRaw())) {
            throw new \Exception("Requested plan '" . $key . "' does not exist.");
        }

        return $this->allRaw()[$key];
    }


    public function getPlan($key)
    {
        // Returns the plan as configured in plans.php
        if (! str_contains($key, '_')) {
            throw new \Exception("If you want to retrieve the original plan from configuration, use the 'raw' methods.");
        }

        // Return the request plan as object
        $temp     = explode("_", $key);
        $planName = $temp[0];
        $duration = $temp[1];

        // Build one of the defaults
        if (empty($duration)) {
            return $this->buildDefaultPlan($this->getPlanRaw($planName));
        }

        // Build a tier plan object
        return $this->buildTier(
            $this->getPlanRaw($planName), $duration === "monthly" ? "month" : "year"
        );
    }


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    private function buildDefaultPlan(array $plan)
    {
        if (! array_key_exists($plan["key"], $this->defaultPlansRaw())) {
            throw new \Exception("Requested plan '" . $plan['key'] . "' does not exist.");
        }

        $planObj = new Plan;
        $planObj->configKey   = $planObj->key = $plan['key'];
        $planObj->title       = $plan['title'];
        $planObj->description = $plan['description'];
        $planObj->limits      = $plan['limits'];
        $planObj->type        = "default";

        return $planObj;
    }



    private function buildTier(array $plan, $chargeMode = ['month', 'year'])
    {
        if (!array_key_exists($plan['key'], $this->tiersRaw())) {
            throw new \Exception("Requested plan '" . $plan['key'] . "' does not exist.");
        }

        $planObj = new Plan;

        $planObj->configKey   = $plan['key'];
        $planObj->key         = $plan['key'] . "_" . $chargeMode . 'ly';
        $planObj->title       = $plan['title'];
        $planObj->description = $plan['description'];
        $planObj->duration    = $chargeMode;
        $planObj->price       = $plan['charge_modes'][$chargeMode]['price'];
        $planObj->limits      = $plan['limits'];
        $planObj->type        = "tier";

        return $planObj;
    }


    /**
     * If logged in user, return his plan
     *
     * @return mixed
     * @throws Authentication
     */
    public function userPlan()
    {
        if (! auth()->check()) {
            throw new Authentication("User is not authenticated");
        }

        return auth()->user()->plan();
    }
}

