<?php

namespace Antares\Foundation;

use ReflectionClass;

class Obj
{
    /**
     * Check if object's property is public
     *
     * @param  mixed  $obj
     * @param  mixed  $property
     * @return bool
     */
    public static function isPublic($obj, $property)
    {
        $prop = (new ReflectionClass($obj))->getProperty($property);
        return $prop->isPublic();
    }

    /**
     * Check if object's property is protected
     *
     * @param  mixed  $obj
     * @param  mixed  $property
     * @return bool
     */
    public static function isProtected($obj, $property)
    {
        $prop = (new ReflectionClass($obj))->getProperty($property);
        return $prop->isProtected();
    }
    
    /**
     * Check if object's property is private
     *
     * @param  mixed  $obj
     * @param  mixed  $property
     * @return bool
     */
    public static function isPrivate($obj, $property)
    {
        $prop = (new ReflectionClass($obj))->getProperty($property);
        return $prop->isPrivate();
    }

    /**
     * Gets the object's property value
     *
     * @param  mixed  $obj
     * @param  mixed  $property
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($obj, $property, $default = null)
    {
        $value = $default;

        if (!is_null($obj)) {
            if (is_array($obj)) {
                $value = Arr::get($obj, $property, $default);
            } elseif (property_exists($obj, $property)) {
                $prop = (new ReflectionClass($obj))->getProperty($property);
                $prop->setAccessible(true);
                $value = $prop->getValue($obj);
            }
        }

        return $value;
    }

    /**
     * Set the object's property value
     *
     * @param  mixed  $obj
     * @param  mixed  $property
     * @param  mixed  $value
     * @return void
     */
    public static function set($obj, $property, $value)
    {
        if (!is_null($obj)) {
            if (is_array($obj)) {
                Arr::set($obj, $property, $value);
            } elseif (property_exists($obj, $property)) {
                $prop = (new ReflectionClass($obj))->getProperty($property);
                $prop->setAccessible(true);
                $prop->setValue($obj, $value);
            }
        }
    }
}
