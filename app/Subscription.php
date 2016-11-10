<?php

namespace App;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'braintree_plan', 'braintree_plan_id');
    }


    public function newFromSubscription($source)
    {
        $instance = $this;

        // $values = get_object_vars($source);

        $instance->setRawAttributes($source->attributes, true);
        $instance->exists = true;

        return $instance;
    }


    public function test()
    {
        dd('nteath');
    }
}
