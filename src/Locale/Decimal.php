<?php

namespace Antares\Foundation\Locale;

use NumberFormatter;

class Decimal extends BaseLocale
{
    /**
     * Decimal separator
     *
     * @var null|string
     */
    protected $decimalSep = null;

    /**
     * Thousands separator
     *
     * @var null|string
     */
    protected $thousandsSep = null;

    /**
     * Percent
     *
     * @var null|string
     */
    protected $percent = null;

    /**
     * Zero digit
     *
     * @var null|string
     */
    protected $zeroDigit = null;

    /**
     * Digit
     *
     * @var null|string
     */
    protected $digit = null;

    /**
     * Minus sign
     *
     * @var null|string
     */
    protected $minusSign = null;

    /**
     * Plus sign
     *
     * @var null|string
     */
    protected $plusSign = null;

    /**
     * Exponential
     *
     * @var null|string
     */
    protected $exponential = null;

    /**
     * Class setup
     *
     * @param string $locale
     * @return void
     */
    public function setup(string $locale): void
    {
        parent::setup($locale);

        $fmt = new NumberFormatter($locale, NumberFormatter::DECIMAL);

        $this->decimalSep = $fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
        $this->thousandsSep = $fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL);
        $this->percent = $fmt->getSymbol(NumberFormatter::PERCENT_SYMBOL);
        $this->zeroDigit = $fmt->getSymbol(NumberFormatter::ZERO_DIGIT_SYMBOL);
        $this->digit = $fmt->getSymbol(NumberFormatter::DIGIT_SYMBOL);
        $this->minusSign = $fmt->getSymbol(NumberFormatter::MINUS_SIGN_SYMBOL);
        $this->plusSign = $fmt->getSymbol(NumberFormatter::PLUS_SIGN_SYMBOL);
        $this->exponential = $fmt->getSymbol(NumberFormatter::EXPONENTIAL_SYMBOL);
    }

    /**
     * Get decimal separator
     *
     * @return  null|string
     */ 
    public function getDecimalSep(): null|string
    {
        return $this->decimalSep;
    }

    /**
     * Get thousands separator
     *
     * @return  null|string
     */ 
    public function getThousandsSep(): null|string
    {
        return $this->thousandsSep;
    }

    /**
     * Get percent
     *
     * @return  null|string
     */ 
    public function getPercent(): null|string
    {
        return $this->percent;
    }

    /**
     * Get sero digit
     *
     * @return  null|string
     */ 
    public function getZeroDigit(): null|string
    {
        return $this->zeroDigit;
    }

    /**
     * Get digit
     *
     * @return  null|string
     */ 
    public function getDigit(): null|string
    {
        return $this->digit;
    }

    /**
     * Get minus sign
     *
     * @return  null|string
     */ 
    public function getMinusSign(): null|string
    {
        return $this->minusSign;
    }

    /**
     * Get plus sign
     *
     * @return  null|string
     */ 
    public function getPlusSign(): null|string
    {
        return $this->plusSign;
    }

    /**
     * Get exponential
     *
     * @return  null|string
     */ 
    public function getExponential(): null|string
    {
        return $this->exponential;
    }

    /**
     * Format given value
     *
     * @param int|float|null $value
     * @param int|null $precision
     * @return string
     */
    public function format($value, int $precision = 2): ?string
    {
        if (is_null($value)) {
            return null;
        }
        $fmt = new NumberFormatter($this->getId(), NumberFormatter::DECIMAL);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);
        return $fmt->format($value);
    }

    /**
     * Parse given value
     *
     * @param int|float|null $value
     * @param int|null $precision
     * @return float|null
     */
    public function parse($value, int $precision = 2): ?float
    {
        if (is_null($value)) {
            return null;
        }
        $fmt = new NumberFormatter($this->getId(), NumberFormatter::DECIMAL);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);
        $parsed = $fmt->parse($value);
        return ($parsed === false) ? null : $parsed;
    }
}
