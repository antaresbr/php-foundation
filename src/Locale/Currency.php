<?php

namespace Antares\Foundation\Locale;

use NumberFormatter;

class Currency extends BaseLocale
{
    /**
     * Code
     *
     * @var null|string
     */
    protected $code = null;

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
     * Symbol
     *
     * @var null|string
     */
    protected $symbol = null;

    /**
     * Affix type
     *
     * @var null|string Possible values: [null | prefix | suffix ]
     */
    protected $affixType = null;

    /**
     * Positive affix
     *
     * @var null|string
     */
    protected $positiveAffix = null;

    /**
     * Negative affix
     *
     * @var null|string
     */
    protected $negativeAffix = null;

    /**
     * Class setup
     *
     * @param string $locale
     * @return void
     */
    public function setup(string $locale): void
    {
        parent::setup($locale);

        $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        $this->code = $fmt->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
        $this->decimalSep = $fmt->getSymbol(NumberFormatter::MONETARY_SEPARATOR_SYMBOL);
        $this->thousandsSep = $fmt->getSymbol(NumberFormatter::MONETARY_GROUPING_SEPARATOR_SYMBOL);
        $this->minusSign = $fmt->getSymbol(NumberFormatter::MINUS_SIGN_SYMBOL);
        $this->plusSign = $fmt->getSymbol(NumberFormatter::PLUS_SIGN_SYMBOL);
        $this->symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

        $affix = $fmt->getTextAttribute(NumberFormatter::POSITIVE_PREFIX);
        if ($affix) {
            $this->affixType = 'prefix';
            $this->positiveAffix = $affix;
            $this->negativeAffix = $fmt->getTextAttribute(NumberFormatter::NEGATIVE_PREFIX);
        } else {
            $affix = $fmt->getTextAttribute(NumberFormatter::POSITIVE_SUFFIX);
            if ($affix) {
                $this->affixType = 'suffix';
                $this->positiveAffix = $affix;
                $this->negativeAffix = $fmt->getTextAttribute(NumberFormatter::NEGATIVE_SUFFIX);
            }
        }
    }

    /**
     * Get code
     *
     * @return  null|string
     */ 
    public function getCode(): null|string
    {
        return $this->code;
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
     * Get symbol
     *
     * @return  null|string
     */ 
    public function getSymbol(): null|string
    {
        return $this->symbol;
    }

    /**
     * Get affix type
     *
     * @return  null|string
     */ 
    public function getAffixType(): null|string
    {
        return $this->affixType;
    }

    /**
     * Get positive affix
     *
     * @return  null|string
     */ 
    public function getPositiveAffix(): null|string
    {
        return $this->positiveAffix;
    }

    /**
     * Get negative affix
     *
     * @return  null|string
     */ 
    public function getNegativeAffix(): null|string
    {
        return $this->negativeAffix;
    }

    /**
     * Sanitize value
     *
     * @param string|null $value
     * @param string $encoding
     * @return string
     */
    public function sanitize($value, $encoding = 'UTF-8'): ?string
    {
        if (is_null($value)) {
            return null;
        }

        $sign = null;
        $sanitized = '';

        $signal_chars = [$this->minusSign, $this->plusSign];
        $valid_chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', $this->decimalSep, $this->thousandsSep];
        $len = mb_strlen($value, $encoding);
        $i = 0;
        while ($i < $len) {
            $char = mb_substr($value, $i, 1, 'UTF-8');
            if (in_array($char, $signal_chars, true)) {
                $sign ??= $char;
            }
            if (in_array($char, $valid_chars, true)) {
                $sanitized .= $char;
            }
            $i++;
        }
        return $sign . $sanitized;
    }

    /**
     * Get affixed value
     *
     * @param string|null $value
     * @return string
     */
    public function affixed($value): ?string
    {
        if (is_null($value)) {
            return null;
        }
        if (is_null($this->affixType) or str_contains($value, $this->negativeAffix) or str_contains($value, $this->positiveAffix)) {
            return $value;
        }
        $value = $this->sanitize($value);
        $isNegative = (!is_null($this->minusSign) and str_starts_with($value, $this->minusSign));
        if (str_starts_with($value, $this->minusSign) or str_starts_with($value, $this->plusSign)) {
            $value = mb_substr($value, 1);
        }
        $affix = ($isNegative) ? $this->negativeAffix : $this->positiveAffix;

        return ($this->affixType == 'prefix') ? "{$affix}{$value}" : "{$value}{$affix}";
    }

    /**
     * Format given value
     *
     * @param int|float|null $value
     * @param int|null $precision
     * @return string
     */
    public function format($value, int $precision = 2, bool $affix = true): ?string
    {
        if (is_null($value)) {
            return null;
        }
        $fmt = new NumberFormatter($this->getId(), NumberFormatter::CURRENCY);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);
        $r = $fmt->format($value);
        if (!$affix) {
            $r = str_replace($this->positiveAffix, '', $r);
        }
        return $r;
    }

    /**
     * Parse given value
     *
     * @param int|float|string|null $locale
     * @return float|null
     */
    public function parse($value, int $precision = 2): ?float
    {
        if (is_null($value)) {
            return null;
        }
        $fmt = new NumberFormatter($this->getId(), NumberFormatter::CURRENCY);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);
        $parsed = $fmt->parseCurrency($this->affixed($value), $symbol);
        return ($parsed === false) ? null : $parsed;
    }
}
