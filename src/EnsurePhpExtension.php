<?php

namespace Antares\Foundation;

use RuntimeException;

class EnsurePhpExtension
{
    /**
     * Array of flags indicating that PHP extension is installed or not.
     *
     * @var array
     */
    protected static $extensions = [];

    /**
     * Ensure the PHP "extension" is installed.
     *
     * @param string $extension
     * @return bool
     */
    public static function isInstalled(string $extension): bool
    {
        if (!array_key_exists($extension, static::$extensions)) {
            static::$extensions[$extension] = extension_loaded($extension);
        }
        if (!static::$extensions[$extension]) {
            $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];

            throw new RuntimeException("The '{$extension}' PHP extension is required to use the ['{$method}'] method.");
        }
        return true;
    }

    /**
     * Ensure the PHP "intl" extension is installed.
     *
     * @return bool
     */
    public static function intl(): bool
    {
        return static::isInstalled(__FUNCTION__);
    }
}
