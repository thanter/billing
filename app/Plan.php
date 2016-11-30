<?php

namespace App;

class Plan
{
    public $key;
    public $title;
    public $price;
    public $limits;
    public $duration;
    public $configKey;
    public $description;
    public $type;


    public function getKey()
    {
        return $this->key;
    }

    public function getPrice($formatted = true)
    {
        if ($formatted) {
            return number_format((int) $this->price / 100);
        }

        return $this->price;
    }



    /**
     * Get a plan's attribute.
     * If provided key does not exist as attribute
     * Check if provided key exists as plan's limit attribute
     * eg. getAttribute('price')
     * eg. getAttribute('limits.entries')
     * eg. getAttribute('entries')
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



    /**
     * Get a plan's limit's value by its key
     *
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function getLimit($key)
    {
        $limits = $this->limits;

        if (! array_key_exists($key, $limits)) {
            throw new \Exception("Key '" . $key . "' is not one of the limits for the plan.");
        }

        return $limits[$key];
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