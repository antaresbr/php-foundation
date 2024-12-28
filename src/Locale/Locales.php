<?php

namespace Antares\Foundation\Locale;

class Locales
{
    /**
     * Array of decimal objects
     *
     * @var array
     */
    protected static $decimals = [];

    /**
     * Array of currency objects
     *
     * @var array
     */
    protected static $currencies = [];

    /**
     * Get default locale ID
     *
     * @return string|null
     */
    protected static function defaultLocale(): string
    {
        $locale = null;
        if (function_exists('app')) {
            $app = call_user_func('app');
            if (is_object($app) and method_exists($app, 'getLocale')) {
                $locale = $app->getLocale();
                if (!is_string($locale)) {
                    $locale = null;
                }
            }
        }
        return $locale;
    }

    /**
     * Get the Decimal object for locale
     *
     * @param null|string $locale
     * @return Decimal|null
     */
    public static function decimal(null|string $locale = null): ?Decimal
    {
        $locale ??= static::defaultLocale();
        if (is_null($locale)) {
            return null;
        }

        if (!array_key_exists($locale, static::$decimals)) {
            static::$decimals[$locale] = new Decimal($locale);
        }
        
        return static::$decimals[$locale];
    }

    /**
     * Get the Currency object for locale
     *
     * @param null|string $locale
     * @return Currency|null
     */
    public static function currency(null|string $locale = null): ?Currency
    {
        $locale ??= static::defaultLocale();
        if (is_null($locale)) {
            return null;
        }

        if (!array_key_exists($locale, static::$currencies)) {
            static::$currencies[$locale] = new Currency($locale);
        }
        
        return static::$currencies[$locale];
    }
}
