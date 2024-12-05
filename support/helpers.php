<?php

use Antares\Foundation\Arr;

if (!function_exists('ai_foundation_infos')) {
    /**
     * Get package infos.
     *
     * @return object
     */
    function ai_foundation_infos()
    {
        return json_decode(file_get_contents(ai_foundation_path('support/infos.json')));
    }
}

if (!function_exists('ai_foundation_path')) {
    /**
     * Return the path of the resource relative to the package
     *
     * @param string $resource
     * @return string
     */
    function ai_foundation_path($resource = null)
    {
        if (!empty($resource) and substr($resource, 0, 1) != DIRECTORY_SEPARATOR) {
            $resource = DIRECTORY_SEPARATOR . $resource;
        }
        return dirname(__DIR__) . $resource;
    }
}

if (!function_exists('ai_foundation_value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function ai_foundation_value($value, ...$args)
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}

if (!function_exists('ai_foundation_env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function ai_foundation_env($key, $default = null)
    {
        $f = 'env';
        if (function_exists($f)) {
            return $f($key, $default);
        }

        $value = getenv($key);
        if ($value === false) {
            return ai_foundation_value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}

if (!function_exists('ai_foundation_config')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function ai_foundation_config($key, $default = null)
    {
        $f = 'config';
        if (function_exists($f)) {
            return $f($key, $default);
        }

        return ai_foundation_value($default);
    }
}

if (!function_exists('ai_foundation_property_value')) {
    /**
     * Gets safely object's property value.
     *
     * @param  mixed  $obj
     * @param  mixed  $property
     * @param  mixed  $default
     * @return mixed
     */
    function ai_foundation_property_value($obj, $property, $default = null)
    {
        $value = $default;

        if (!is_null($obj)) {
            if (is_array($obj)) {
                $value = Arr::get($obj, $property, $default);
            }
            elseif (property_exists($obj, $property)) {
                $prop = (new ReflectionClass($obj))->getProperty($property);
                $prop->setAccessible(true);
                $value = $prop->getValue($obj);
            }
        }

        return $value;
    }
}
