<?php

namespace Antares\Foundation\Collection;

class AssociativeCollection extends AbstractCollection
{
    /**
     * Create a new instance of this object.
     *
     * @param  Class  $type
     * @return void
     */
    public function __construct($type, $unique = true, $acceptNulls = true)
    {
        parent::__construct($type, true, $unique, $acceptNulls);
    }

    /**
     * Add collection item
     *
     * @param  mixed $key
     * @param  mixed $item
     * @return boolean
     */
    public function add($key, $item)
    {
        return parent::_add($key, $item);
    }

    /**
     * Add collection item, if it not exists
     *
     * @param  mixed $key
     * @param  mixed $item
     * @return boolean
     */
    public function addIfNotExists($key, $item)
    {
        if (!$this->hasKey($key)) {
            return $this->add($key, $item);
        }

        return true;
    }

    /**
     * Delete collection item
     *
     * @param  mixed $key
     * @return boolean
     */
    public function delete($key)
    {
        return parent::_deleteKey($key);
    }

    /**
     * Delete collection item, if it exists
     *
     * @param  mixed $key
     * @return boolean
     */
    public function deleteIfExists($key)
    {
        if ($this->hasKey($key)) {
            return $this->delete($key);
        }

        return true;
    }
}
