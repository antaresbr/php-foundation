<?php

namespace Antares\Foundation;

use ReflectionClass;

class Obj
{
    /**
     * Check if object's property is public
     *
     * @param  object|string  $target
     * @param  string  $property
     * @return bool
     */
    public static function isPublic(object|string $obj, string $property): bool
    {
        $prop = (new ReflectionClass($obj))->getProperty($property);
        return $prop->isPublic();
    }

    /**
     * Check if object's property is protected
     *
     * @param  object|string  $target
     * @param  string  $property
     * @return bool
     */
    public static function isProtected(object|string $obj, string $property): bool
    {
        $prop = (new ReflectionClass($obj))->getProperty($property);
        return $prop->isProtected();
    }
    
    /**
     * Check if object's property is private
     *
     * @param  object|string  $target
     * @param  string  $property
     * @return bool
     */
    public static function isPrivate(object|string $obj, string $property): bool
    {
        $prop = (new ReflectionClass($obj))->getProperty($property);
        return $prop->isPrivate();
    }

    /**
     * Gets the object's property value
     *
     * @param  object|string  $target
     * @param  string  $property
     * @param  mixed  $default
     * @return mixed
     */
    public static function get(object|string $target, string $property, $default = null): mixed
    {
        $value = $default;

        if (!is_null($target) and property_exists($target, $property)) {
            $prop = (new ReflectionClass($target))->getProperty($property);
            $prop->setAccessible(true);
            $value = $prop->getValue(is_string($target) ? null : $target);
        }

        return $value;
    }

    /**
     * Set the object's property value
     *
     * @param  object|string  $target
     * @param  string  $property
     * @param  mixed  $value
     * @return void
     */
    public static function set(object|string|array $target, string $property, $value)
    {
        if (!is_null($target) and property_exists($target, $property)) {
            $prop = (new ReflectionClass($target))->getProperty($property);
            $prop->setAccessible(true);
            $prop->setValue(is_string($target) ? null : $target, $value);
        }
    }

    /**
     * Safe method call
     *
     * @param  object|string  $target
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     */
    public static function safeCall(object|string $target, string $method, array $args = []): mixed
    {
        if (!is_null($target) and method_exists($target, $method)) {
            $callback = (new ReflectionClass($target))->getMethod($method);
            $callback->setAccessible(true);
            return $callback->invoke(is_string($target) ? null : $target, ...$args);
        }
        return null;
    }
}
