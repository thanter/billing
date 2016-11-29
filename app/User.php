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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function subscription()
    {
        $latestSubscription = $this->subscriptions()->first();

        if ($latestSubscription) {
            $latestSubscription = (new \App\Subscription)->newFromSubscription(
                $latestSubscription
            );
        }

        return $latestSubscription;
    }


    /**
     * User's current plan
     *
     * @return mixed
     */
    public function plan()
    {
        $planName = $this->subscription()->braintree_plan;

        return plan($planName);
    }
}
