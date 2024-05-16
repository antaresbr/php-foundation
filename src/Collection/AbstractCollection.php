<?php

namespace Antares\Foundation\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

abstract class AbstractCollection implements ArrayAccess, Countable, IteratorAggregate, Traversable, JsonSerializable
{
    /**
     * Valid types for collectoin items
     */
    const VALID_TYPES = 'boolean,integer,double,float,string,array,callable,iterable,mixed';

    /**
     * The class name of the items
     *
     * @var string
     */
    private $type = null;

    /**
     * Flag to indicate whether the items array is associative or not
     *
     * @var boolean
     */
    private $associative;

    /**
     * Flag to indicate whether this collection has unique items
     *
     * @var boolean
     */
    private $unique;

    /**
     * Flag to indicate whether this collection accept null item
     *
     * @var boolean
     */
    private $acceptNulls;

    /**
     * The array with the items
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new instance of this object.
     *
     * @param  string  $type
     * @return void
     */
    public function __construct($type, $associative = true, $unique = true, $acceptNulls = true)
    {
        if (empty($type)) {
            throw CollectionException::forNotDefinedItemType();
        }

        if (strpos(static::VALID_TYPES . ',', strtolower($type) . ',') !== false) {
            $this->type = strtolower($type);
        } else {
            if (class_exists($type)) {
                $this->type = $type;
            } else {
                throw CollectionException::forNonExistentType($type);
            }
        }

        $this->associative = $associative;
        $this->unique = $unique;
        $this->acceptNulls = $acceptNulls;
    }

    /**
     * Get collection type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Chick if this collection is empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * Get associative flag
     *
     * @return boolean
     */
    public function isAssociative()
    {
        return $this->associative;
    }

    /**
     * Get unique flag
     *
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * Get accept null flag
     *
     * @return boolean
     */
    public function canAcceptNulls()
    {
        return $this->acceptNulls;
    }

    /**
     * Get collection data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Clear collection
     *
     * @return void
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Get items data itself
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Get collection keys
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * Get collection values
     *
     * @return array
     */
    public function values()
    {
        return array_values($this->data);
    }

    /**
     * Validate item type
     *
     * @param  mixed $item
     * @return boolean
     */
    protected function validateItemType($item)
    {
        if ($this->type != 'mixed') {
            $type = gettype($item);

            if ($type == 'object') {
                if (!($item instanceof $this->type)) {
                    throw CollectionException::forInvalidItemType($this->type, $type);
                }
            } else {
                if ($type != $this->type) {
                    throw CollectionException::forInvalidItemType($this->type, $type);
                }
            }
        }

        return true;
    }

    /**
     * Check if the collection has the target key
     *
     * @param  mixed $key
     * @param  boolean $throwException
     * @return boolean
     */
    public function hasKey($key, $throwException = false)
    {
        $key = isset($key) ? trim($key) : null;
        if ($key == '') {
            $key = null;
        }

        if (empty($key)) {
            throw CollectionException::forNoKeySupplied();
        }

        $r = array_key_exists($key, $this->data);

        if (!$r and $throwException) {
            throw CollectionException::forKeyNotFound($key);
        }

        return $r;
    }

    /**
     * Check if the collection has the target item
     *
     * @param  mixed $item
     * @param  boolean $throwException
     * @return boolean
     */
    public function hasItem($item, $throwException = false)
    {
        $r = (array_search($item, $this->data) !== false);

        if (!$r and $throwException) {
            throw CollectionException::forItemNotFound($item);
        }

        return $r;
    }

    /**
     * Get collection key from item
     *
     * @param  mixed $item
     * @param  mixed $throwExceptionIfNotFound
     * @return mixed
     */
    public function getKey($item, $throwExceptionIfNotFound = true)
    {
        return $this->hasItem($item, $throwExceptionIfNotFound) ? array_search($item, $this->data) : null;
    }

    /**
     * Get collection item from key
     *
     * @param  mixed $key
     * @param  mixed $throwExceptionIfNotFound
     * @return mixed
     */
    public function getItem($key, $throwExceptionIfNotFound = true)
    {
        return $this->hasKey($key, $throwExceptionIfNotFound) ? $this->data[$key] : null;
    }

    /**
     * Add collection item with in a key (key is optinal in simple collection)
     *
     * @param  mixed $key
     * @param  mixed $item
     * @param  mixed $inserting
     * @return boolean
     */
    protected function _add($key, $item, $inserting = false)
    {
        $key = isset($key) ? trim($key) : null;
        if ($key == '') {
            $key = null;
        }

        if (isset($key) and $this->hasKey($key) and ($this->isAssociative() or !$inserting)) {
            throw CollectionException::forAlreadyDefinedKey($key);
        }

        if ($this->isUnique() and $this->hasItem($item)) {
            throw CollectionException::forItemAlreadyExists($item);
        }

        if ($this->isAssociative() and !isset($key)) {
            throw CollectionException::forNoKeySupplied();
        }

        $this->validateItemType($item);

        if ($this->isAssociative() or (isset($key) and !$this->hasKey($key))) {
            $this->data[$key] = $item;
        } else {
            if (isset($key)) {
                array_splice($this->data, $key, 0, $item);
            } else {
                array_push($this->data, $item);
            }
        }

        return true;
    }

    /**
     * Delete collection item from key
     *
     * @param  mixed $key
     * @return boolean
     */
    protected function _deleteKey($key)
    {
        $this->hasKey($key, true);

        unset($this->data[$key]);

        return true;
    }

    /**
     * Delete collection item
     *
     * @param  mixed $item
     * @return boolean
     */
    protected function _deleteItem($item)
    {
        $this->hasItem($item, true);

        unset($this->data[array_search($item, $this->data)]);

        return true;
    }

    //--[ implements : start ]--

    //-- implements : ArrayAccess

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return $this->hasKey($key);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet(mixed $key): mixed
    {
        return $this->getItem($key);
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->_add($key, $value);
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key): void
    {
        $this->_deleteKey($key);
    }

    //-- implements : Countable

    /**
     * Get items count
     *
     * @return integer
     */
    public function count(): int
    {
        return count($this->data);
    }

    //-- IteratorAggregate, Traversable

    /**
     * Get itarator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    //-- JsonSerializable

    /**
     * Get items data itself for serialization
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
