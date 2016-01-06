<?php

namespace App\Services;

use Illuminate\Support\Facades\Event;
use Stevebauman\Purify\Facades\Purify;

/**
 * Class Service.
 */
abstract class Service
{
    /*
     * Holds the data to be inserted into the database
     */
    protected $input = [];

    /**
     * Set's the input data to be inserted into DB.
     *
     * @param array $input
     *
     * @return $this
     */
    public function setInput($input = [])
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Retrieves data from the input array.
     *
     * @param string $field
     * @param mixed  $default
     * @param bool   $clean
     *
     * @return null|mixed
     */
    public function getInput($field, $default = null, $clean = false)
    {
        /*
         * If the field exists in the input array
         */
        if (array_key_exists($field, $this->input)) {
            /*
             * If clean is set to true, clean the input and return it
             */
            if ($clean) {
                return $this->clean($this->input[$field]);
            }

            /*
             * If clean is set to false, return the input
             */
            return $this->input[$field];
        } else {
            /*
             * If key does not exist in the input array, and a
             * default value is specified, return the default value
             */
            if ($default !== null) {
                return $default;
            }

            /*
             * Return NULL if the default value is not set
             */
            return;
        }
    }

    /**
     * Cleans input from data removing invalid HTML tags such as scripts.
     *
     * @param string $input
     *
     * @return mixed
     */
    protected function clean($input)
    {
        if ($input) {
            $cleaned = Purify::clean($input);

            return $cleaned;
        }

        return;
    }

    /**
     * Alias for firing events easily that extend from this class.
     *
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    protected function fireEvent($name, $args = [])
    {
        return Event::fire((string) $name, (array) $args);
    }
}
