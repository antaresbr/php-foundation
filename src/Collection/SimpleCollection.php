<?php

namespace Antares\Foundation\Collection;

class SimpleCollection extends AbstractCollection
{
    /**
     * Create a new instance of this object.
     *
     * @param  Class  $type
     * @return void
     */
    public function __construct($type, $unique = true, $acceptNulls = true)
    {
        parent::__construct($type, false, $unique, $acceptNulls);
    }

    /**
     * Add collection item
     *
     * @param  mixed $item
     * @return boolean
     */
    public function add($item)
    {
        return parent::_add(null, $item);
    }

    /**
     * Insert collection item in specific key
     *
     * @param  mixed $key
     * @param  mixed $item
     * @return boolean
     */
    public function insert($item, $key)
    {
        return parent::_add($key, $item, true);
    }

    /**
     * Add collection item, if it not exists
     *
     * @param  mixed $item
     * @return boolean
     */
    public function addIfNotExists($item)
    {
        if (!$this->hasItem($item)) {
            return $this->add($item);
        }

        return true;
    }

    /**
     * Delete collection item
     *
     * @param  mixed $item
     * @return boolean
     */
    public function delete($item)
    {
        return parent::_deleteItem($item);
    }

    /**
     * Delete collection item, if it exists
     *
     * @param  mixed $item
     * @return boolean
     */
    public function deleteIfExists($item)
    {
        if ($this->hasItem($item)) {
            return $this->delete($item);
        }

        return true;
    }
}
