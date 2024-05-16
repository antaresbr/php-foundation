<?php

namespace Antares\Foundation\Collection;

use Exception;

class CollectionException extends Exception
{
    /**
     * Create a new exception for not defined item type
     *
     * @return static
     */
    public static function forNotDefinedItemType()
    {
        return new static('Item type not defined.');
    }

    /**
     * Create a new exception for non existent type
     *
     * @param  string  $type
     * @return static
     */
    public static function forNonExistentType($type)
    {
        return new static("Non existent type: {$type}.");
    }

    /**
     * Create a new exception for invalid type
     *
     * @param  string  $collectionType
     * @param  string  $type
     * @return static
     */
    public static function forInvalidItemType($collectionType, $type)
    {
        return new static("The collection type '{$collectionType}' cannot have item of type '{$type}'.");
    }

    /**
     * Create a new exception for no key supplied
     *
     * @return static
     */
    public static function forNoKeySupplied()
    {
        return new static('No key supplied.');
    }

    /**
     * Create a new exception for no item supplied
     *
     * @return static
     */
    public static function forNoItemSupplied()
    {
        return new static('No item supplied.');
    }

    /**
     * Create a new exception for already defined Key
     *
     * @param  mixed  $key
     * @return static
     */
    public static function forAlreadyDefinedKey($key)
    {
        return new static("Already defined key: {$key}.");
    }

    /**
     * Create a new exception for item that already exists in the collection
     *
     * @param  mixed  $item
     * @return static
     */
    public static function forItemAlreadyExists($item)
    {
        return new static('Collection item already exists: ' . print_r($item, true));
    }

    /**
     * Create a new exception for key not found
     *
     * @param  mixed  $key
     * @return static
     */
    public static function forKeyNotFound($key)
    {
        return new static("Key not found: '{$key}'.");
    }

    /**
     * Create a new exception for item not found
     *
     * @param  mixed  $item
     * @return static
     */
    public static function forItemNotFound($item)
    {
        return new static('Item not found: ' . print_r($item, true));
    }
}
