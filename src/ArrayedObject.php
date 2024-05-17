<?php

namespace Antares\Foundation;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;
use Traversable;

class ArrayedObject implements ArrayAccess, Countable, IteratorAggregate, Traversable, JsonSerializable, Serializable
{
    /**
     * Protected storage data
     *
     * @var array
     */
    protected $storage = [];

    /**
     * Setup storage data
     * 
     * @param array|null $data Data to be stored.
     * @return void
     */
    public function setup(?array $data = null): void
    {
        if ($data === null) {
            $data = [];
        }
        $this->storage = $data;
    }

    /**
     * Get protected storage data
     *
     * @return array
     */
    public function all(): array
    {
        return $this->storage;
    }

    /**
     * Get storage array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     * Check if this infos has en empty storage data
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->storage);
    }

    /**
     * Check if key is present in storage data
     *
     * @param mixed $key The key to serach
     * @return bool
     */
    public function has($key): bool
    {
        return Arr::has($this->storage, $key);
    }

    /**
     * Set key value
     *
     * @param mixed $key The key to set value
     * @param mixed $value The The value
     * @return void
     */
    public function set($key, $value): void
    {
        Arr::set($this->storage, $key, $value);
    }

    /**
     * Forget key
     *
     * @param mixed $key The key to forget
     * @param mixed $value The The value
     * @return void
     */
    public function forget($key): void
    {
        Arr::forget($this->storage, $key);
    }

    /**
     * Get key value
     *
     * @param string $key The key to serach value
     * @param mixed  $default The default value, if key does not exists
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        return Arr::get($this->storage, $key, $default);
    }

    /**
     * Check if an key is set
     *
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }

    /**
     * Get key value
     *
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->get($key);
    }

    /**
     * Set an key/value pair
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set(string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    //--[ implements : start ]--

    //-- implements : ArrayAccess

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists(mixed $key): bool
    {
        return $this->has($key);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet(mixed $key): mixed
    {
        //return Arr::get($this->storage, $key);
        return $this->get($key);
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
        if (is_null($key)) {
            $this->storage[] = $value;
        }
        else {
            $this->set($key, $value);
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key): void
    {
        $this->forget($key);
    }

    //-- implements : Countable

    /**
     * Get items count
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->storage);
    }

    //-- IteratorAggregate, Traversable

    /**
     * Get itarator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->storage);
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

    //-- Serializable

    public function __serialize(): array {
        return $this->storage;
    }

    public function __unserialize(?array $data): void {
        $this->setup($data);
    }

    public function serialize(): ?string {
        return serialize($this->__serialize());
    }

    public function unserialize($data): void {
        $this->__unserialize(unserialize($data));
    }
}
