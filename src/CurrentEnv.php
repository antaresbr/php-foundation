<?php

namespace Antares\Foundation;

class CurrentEnv
{
    /**
     * Arrayed OS env
     * 
     * @var ArrayedObject
     */
    protected $_osenv = null;

    /**
     * Access protected _osenv property
     */
    public function osenv(): ArrayedObject {
        if ($this->_osenv === null) {
            $this->_osenv = new ArrayedObject();
        }
        return $this->_osenv;
    }

    /**
     * Arrayed global _ENV
     * 
     * @var ArrayedObject
     */
    protected $_ENV;

    /**
     * Access protected _ENV property
     */
    public function ENV(): ArrayedObject {
        if ($this->_ENV === null) {
            $this->_ENV = new ArrayedObject();
        }
        return $this->_ENV;
    }

    /**
     * Arrayed global _SERVER
     * 
     * @var ArrayedObject
     */
    protected $_SERVER;

    /**
     * Access protected _ENV property
     */
    public function SERVER(): ArrayedObject {
        if ($this->_SERVER === null) {
            $this->_SERVER = new ArrayedObject();
        }
        return $this->_SERVER;
    }

    /**
     * Reset environment variable to this CurrentEnv object
     * 
     * @return void
     */
    public function resetToThis(): void
    {
        $current = getenv();
        foreach ($current as $key => $value) {
            if (!array_key_exists($key, $this->osenv()->all())) {
                putenv($key);
            }
        }
        foreach ($this->osenv()->all() as $key => $value) {
            putenv("{$key}={$value}");
        }

        $current = $_ENV;
        foreach ($current as $key => $value) {
            if (!array_key_exists($key, $this->ENV()->all())) {
                unset($_ENV[$key]);
            }
        }
        foreach ($this->ENV()->all() as $key => $value) {
            $_ENV[$key] = $value;
        }

        $current = $_SERVER;
        foreach ($current as $key => $value) {
            if (!array_key_exists($key, $this->SERVER()->all())) {
                unset($_SERVER[$key]);
            }
        }
        foreach ($this->SERVER()->all() as $key => $value) {
            $_SERVER[$key] = $value;
        }
    }

    /**
     * Create instance with current environment variables
     * 
     * @return static
     */
    public static function make()
    {
        $instance = new static;
        $instance->osenv()->setup(getenv());
        $instance->ENV()->setup($_ENV);
        $instance->SERVER()->setup($_SERVER);
        return $instance;
    }
}
