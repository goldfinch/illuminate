<?php

use SilverStripe\Core\Environment;

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @return mixed
     */
    function env($key)
    {
        return Environment::getEnv($key);
    }
}
