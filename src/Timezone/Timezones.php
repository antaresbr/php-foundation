<?php

namespace Antares\Foundation\Timezone;

class Timezones
{
    /**
     * Array of timezone objects
     *
     * @var array
     */
    protected static $timezones = [];

    /**
     * Get the Timezone object
     *
     * @param null|string $timezone
     * @return Timezone|null
     */
    public static function timezone(null|string $timezone = null): ?Timezone
    {
        if (is_null($timezone) and function_exists('config')) {
            $timezone = call_user_func('config', 'app.timezone');
        }
        if (is_null($timezone) or $timezone === false) {
            return null;
        }

        if (!array_key_exists($timezone, static::$timezones)) {
            static::$timezones[$timezone] = new Timezone($timezone);
        }
        
        return static::$timezones[$timezone];
    }
}
