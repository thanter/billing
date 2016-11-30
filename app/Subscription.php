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
        $this->setRawAttributes($source->attributes, true);
        $this->exists = true;

        return $this;
    }
}
