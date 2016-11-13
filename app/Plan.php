<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = ['name', 'period', 'price', 'priceName', 'braintree_plan_id'];


    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }


    /**
     * All subscriptions that are on this plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'braintree_plan', 'braintree_plan_id');
    }


    public function hasHigher()
    {
        return $this->name === 'low_monthly';
    }


    public function hasLower()
    {
        return $this->name === 'high_monthly';
    }
}