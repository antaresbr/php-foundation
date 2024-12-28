<?php

namespace Antares\Foundation\Locale;

use Antares\Foundation\EnsurePhpExtension;

class BaseLocale
{
    /**
     * Locale ID
     *
     * @var null|string
     */
    protected $id = null;

    /**
     * Locale ISO ID
     *
     * @var null|string
     */
    protected $isoId = null;

    /**
     * Class constructor
     *
     * @param string $locale
     */
    public function __construct(string $locale)
    {
        EnsurePhpExtension::intl();
        $this->setup($locale);
    }

    /**
     * Class setup
     *
     * @param string $locale
     */
    public function setup(string $locale)
    {
        $this->id = $locale;

        $iso = explode('_', $this->id);
        $iso1 = strtolower(array_shift($iso));
        $iso2 = strtoupper(implode('-', $iso));

        $this->isoId = $iso1;
        if (!empty($iso2)) {
            $this->isoId .= "-{$iso2}";
        }
    }

    /**
     * Get locale ID
     *
     * @return  null|string
     */ 
    public function getId(): null|string
    {
        return $this->id;
    }

    /**
     * Get locale ISO ID
     *
     * @return  null|string
     */ 
    public function getIsoId(): null|string
    {
        return $this->isoId;
    }
}
