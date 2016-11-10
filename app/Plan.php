<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = ['name', 'period', 'price', 'priceName', 'braintree_plan_id'];





    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'braintree_plan', 'braintree_plan_id');
    }
}