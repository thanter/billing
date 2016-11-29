<?php

namespace App;

use Braintree\Exception\Authentication;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;


class PlanConfig
{
    protected $auth;

    protected $plans;

    public function __construct(Guard $guard)
    {
        $this->auth  = $guard;
        $this->plans = config('plans.available');
    }


    public function all()
    {
        $plans = new Collection;

        foreach($this->plans as $key => $plan) {
            $plans->add(new Plan($plan));
        }

        return $plans;
    }


    public function getPlan($planName, $asArray = false)
    {
        $plans = $this->plans;

        if (array_key_exists($planName, $plans)) {
            $plan = $plans[$planName];

            return $asArray ? $plan : new Plan($plans[$planName]);
        }


        throw new \Exception("Requested plan '".$planName."' does not exist.");
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

