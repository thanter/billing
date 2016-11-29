<?php

namespace App;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    /**
     * The plan of the subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        $planName = $this->braintree_plan;

        return plan($planName);
    }


    public function newFromSubscription($source)
    {
        $instance = $this;

        // $values = get_object_vars($source);

        $instance->setRawAttributes($source->attributes, true);
        $instance->exists = true;

        return $instance;
    }
}
