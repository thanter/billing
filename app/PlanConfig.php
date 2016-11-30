<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;
use Braintree\Exception\Authentication;
use Illuminate\Database\Eloquent\Collection;


class PlanConfig
{
    protected $auth;

    protected $allPlans;
    protected $paidPlans;
    protected $defaultPlans;

    public function __construct(Guard $guard)
    {
        $this->auth  = $guard;
        $this->paidPlans = config('plans.paid');
        $this->defaultPlans = config('plans.default');
        $this->allPlans = array_merge($this->defaultPlans, $this->paidPlans);
    }



    private function build(array $plan, $chargeMode = ['month', 'year'])
    {
        dd($plan);
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



    public function paid()
    {
        $plans = new Collection;

        foreach ($this->paidPlans as $plan) {
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

        return $this->build($this->allPlans[$planName], $duration);
    }


    public function allRaw()
    {
        return array_merge($this->defaultPlans, $this->paidPlans);
    }


    public function paidRaw()
    {
        return $this->paidPlans;
    }



    public function getRaw($planName)
    {
        if (!array_key_exists($planName, $this->allPlans)) {
            throw new \Exception("Requested plan '" . $planName . "' does not exist.");
        }

        return $this->allPlans[$planName];
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

