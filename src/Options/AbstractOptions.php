<?php

namespace Antares\Foundation\Options;

use Antares\Foundation\Arr;
use Antares\Foundation\ArrayedObject;

abstract class AbstractOptions extends ArrayedObject
{
    //---[ overrides : start ]---

    /**
     * Get protected storage data
     *
     * @param bool $includeAbsentProperties
     * @return array
     */
    public function all(bool $includeAbsentProperties = false): array
    {
        if (!$includeAbsentProperties) {
            return $this->storage;
        }

        $data = [];
        foreach (array_keys($this->prototypes) as $key) {
            $data[$key] = $this->get($key);
        }
        return $data;
    }

    /**
     * Get storage array
     *
     * @param boolean $includeAbsentProperties
     * @return array
     */
    public function toArray(bool $includeAbsentProperties = false): array
    {
        return $this->all($includeAbsentProperties);
    }

    /**
     * Get key value
     *
     * @param string $key The key to serach value
     * @param array $prototype The prototype used to get the value
     * @return mixed
     */
    public function get($key, $prototype = []): mixed
    {
        if (empty($key)) {
            throw OptionsException::forNoKeySupplied();
        }

        if (!empty($this->prototypes) and !Arr::has($this->prototypes, $key)) {
            throw OptionsException::forInvalidOption($key, implode(' | ', array_keys($this->prototypes)));
        }

        if (empty($prototype)) {
            $prototype = Arr::get($this->prototypes, $key, []);
        }

        $default = Arr::get($prototype, 'default');

        return Arr::get($this->storage, $key, $default);
    }

    /**
     * Check if an property exists
     *
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return ($this->has($key) or Arr::has($this->prototypes, $key));
    }

    //---[ overrides : end ]---

    /**
     * The options prototypes
     *
     * @var array
     */
    protected $prototypes;

    /**
     * Set protected property data
     *
     * @return void
     */
    public function reset(array $data = []): void
    {
        $this->setup($data);
    }

    /**
     * Get md5 hash from property $data
     *
     * @return string
     */
    public function hash()
    {
        return empty($this->storage) ? '' : md5(serialize($this->storage));
    }

    /**
     * Validate the supplied value against valid values
     *
     * @param mixed $value The value to be validated
     * @param string|array $validValues The possible valid values list
     * @return mixed
     */
    public function isValidValue($value, $validValues)
    {
        $validValues = Arr::arrayed($validValues);

        return (array_search($value, $validValues) !== false);
    }

    /**
     * Protected prototypes property accessor
     *
     * @return array
     */
    public function getPrototypes()
    {
        return $this->prototypes;
    }

    /**
     * Get option prototype
     *
     * @return array
     */
    public function getPrototype($key)
    {
        if (!array_key_exists($key, $this->prototypes)) {
            throw OptionsException::forOptionPrototypeNotFound($key);
        }

        return $this->prototypes[$key];
    }

    /**
     * Set options prototypes
     *
     * @param array $prototypes
     * @return static
     */
    abstract public function setPrototypes(array $prototypes);
}
