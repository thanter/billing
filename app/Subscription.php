<?php

namespace App;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    public function isActive()
    {
        return (bool) $this->active();
    }


    public function newFromSubscription($source)
    {
        $this->setRawAttributes($source->attributes, true);
        $this->exists = true;

        return $this;
    }
}
