<?php

namespace App;

class Plan
{
    protected $key;
    protected $title;
    protected $description;
    protected $price;
    protected $limits;

    public function __construct($plan)
    {
        foreach($plan as $key => $value) {
            $this->$key = $value;
        }
    }


    public function getKey()
    {
        return $this->key;
    }

    public function getTitle()
    {
        return $this->title;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function getPrice($formatted = true)
    {
        if ($formatted) {
            return number_format($this->price / 100);
        }

        return $this->price;
    }


    public function getLimits()
    {
        return $this->limits;
    }


    /**
     * Get a plan's limit's value by its key
     *
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function getLimit($key)
    {
        $limits = $this->getLimits();

        if (! array_key_exists($key, $limits)) {
            throw new \Exception("Key '" . $key . "' is not one of the limits for the plan.");
        }

        return $this->$limits[$key];
    }


    /**
     * Get a plan's attribute.
     * If provided key does not exist as attribute
     * Check if provided key exists as plan's limit attribute
     *
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, get_object_vars($this))) {
            return $this->$key;
        }

        $planAsArray = array_dot((array) $this);

        return array_key_exists($key, $planAsArray)
                    ? $planAsArray[$key]
                    : $this->getLimit($key);
    }






    public function hasHigher()
    {
        return in_array($this->key, ['silver', 'bronze']);
    }


    public function hasLower()
    {
        return in_array($this->key, ['silver', 'golden']);
    }
}