<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Billable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function isPaid()
    {
        $lastSubscription = $this->subscription();

        // User does not have a subscription yet
        if (is_null($lastSubscription)) {
            return false;
        }

        return (bool) $lastSubscription->isActive();
    }


    public function subscription()
    {
        $lastSubscription = $this->subscriptions()->first();

        // User does not have a subscription yet
        if (is_null($lastSubscription)) {
            return null;
        }

        return (new \App\Subscription)->newFromSubscription(
            $lastSubscription
        );
    }


    /**
     * User's current plan
     *
     * @return mixed
     */
    public function plan()
    {
        $lastSubscription = $this->subscription();

        if ($lastSubscription and $lastSubscription->isActive()) {
            $planName = $lastSubscription->braintree_plan;
        }
        else {
            $planName = $this->status . '_';
        }


        return plan($planName);
    }
}
