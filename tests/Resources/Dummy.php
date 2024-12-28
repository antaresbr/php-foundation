<?php

namespace Antares\Foundation\Tests\Resources;

class Dummy
{
    public $publicVar = 'public content';

    protected $protectedVar = 'protected content';

    private $privateVar = 'private content';

    public static $publicStaticVar = 'public static content';

    protected static $protectedStaticVar = 'protected static content';

    private static $privateStaticVar = 'private static content';

    public static function argsToText(...$args): string {
        $text = empty($args) ? '' : implode(',', $args);
        return empty($text) ? '' : " / {$text}";
    }

    public function getPublicVar(...$args): string
    {
        return $this->publicVar . static::argsToText(...$args);
    }

    public function getProtectedVar(...$args): string
    {
        return $this->protectedVar . static::argsToText(...$args);
    }

    public function getPrivateVar(...$args): string
    {
        return $this->privateVar . static::argsToText(...$args);
    }

    public static function getPublicStaticVar(...$args): string
    {
        return static::$publicStaticVar . static::argsToText(...$args);
    }

    public static function getProtectedStaticVar(...$args): string
    {
        return static::$protectedStaticVar . static::argsToText(...$args);
    }

    public static function getPrivateStaticVar(...$args): string
    {
        return static::$privateStaticVar . static::argsToText(...$args);
    }

    /**
     * For Locale tests to get default locale
     */
    public function getLocale(): string
    {
        return 'pt_BR';
    }
}
