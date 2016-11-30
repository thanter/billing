<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;
use Braintree\Exception\Authentication;
use Illuminate\Database\Eloquent\Collection;


class PlanConfig
{
    protected $auth;

    protected $plans;

    public function __construct(Guard $guard)
    {
        $this->auth  = $guard;
        $this->plans = config('plans.available');
    }



    private function build(array $plan, $chargeMode = ['month', 'year'])
    {
        if (!array_key_exists($plan['key'], $this->plans)) {
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

        return $planObj;
    }



    public function all()
    {
        $plans = new Collection;

        foreach ($this->plans as $plan) {
            foreach ($plan['charge_modes'] as $duration => $info) {
                $plans->add($this->build($plan, $duration));
            }
        }

        return $plans;
    }



    /**
     * Returns the plan as object
     * Make sure it contains _
     *
     * @param $planName
     * @return Plan
     * @throws \Exception
     */
    public function get($planName)
    {
        // Returns the plan as configured in plans.php
        if (!str_contains($planName, '_')) {
            throw new \Exception("If you want to retrieve the original plan configuration, use getRaw()");
        }

        // Return the request plan as object
        $temp     = explode("_", $planName);
        $planName = $temp[0];
        $duration = $temp[1] === "monthly" ? "month" : "year";

        return $this->build($this->plans[$planName], $duration);
    }



    public function allRaw()
    {
        return $this->plans;
    }



    public function getRaw($planName)
    {
        if (!array_key_exists($planName, $this->plans)) {
            throw new \Exception("Requested plan '" . $planName . "' does not exist.");
        }

        return $this->plans[$planName];
    }


    /**
     * If logged in user, return his plan
     *
     * @return mixed
     * @throws Authentication
     */
    public function userPlan()
    {
        if (! $this->auth->check()) {
            throw new Authentication("User is not authenticated");
        }

        return $this->auth->user()->plan();
    }
}

