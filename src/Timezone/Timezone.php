<?php

namespace Antares\Foundation\Timezone;

use Antares\Foundation\EnsurePhpExtension;
use IntlTimeZone;

class Timezone
{
    /**
     * Timezone instance
     *
     * @var null|IntlTimezone
     */
    protected $instance = null;

    /**
     * Timezone ID
     *
     * @var null|string
     */
    protected $id = null;

    /**
     * Timezone name
     *
     * @var null|string
     */
    protected $name = null;

    /**
     * Timezone raw offset (without DST)
     *
     * @var null|int
     */
    protected $rawOffset = null;

    /**
     * Timezone raw offset label (without DST)
     *
     * @var null|string
     */
    protected $rawOffsetLabel = null;

    /**
     * Class constructor
     *
     * @param string $timezone
     */
    public function __construct(string $timezone)
    {
        EnsurePhpExtension::intl();
        $this->setup($timezone);
    }

    /**
     * Class setup
     *
     * @param string $timezone
     * @return void
     */
    protected function setup(string $timezone): void
    {
        $this->instance = IntlTimeZone::createTimeZone($timezone);
        
        $this->id = $timezone;
        $this->name = $this->instance->getDisplayName();
        $this->rawOffset = $this->instance->getRawOffset();
        $this->rawOffsetLabel = str_replace('GMT', 'UTC', $this->instance->getDisplayName(style: IntlTimeZone::DISPLAY_LONG_GMT));
    }

    /**
     * Get timezone instance
     *
     * @return null|IntlTimeZone
     */ 
    public function getIntance(): null|IntlTimeZone
    {
        return $this->instance;
    }

    /**
     * Get locale ID
     *
     * @return null|string
     */ 
    public function getId(): null|string
    {
        return $this->id;
    }

    /**
     * Get locale name
     *
     * @return null|string
     */ 
    public function getName(): null|string
    {
        return $this->name;
    }

    /**
     * Get locale raw offset (without DST)
     *
     * @return null|int
     */ 
    public function getRawOffset(): null|int
    {
        return $this->rawOffset;
    }

    /**
     * Get locale raw offset label (without DST)
     *
     * @return null|string
     */ 
    public function getRawOffsetLabel(): null|string
    {
        return $this->rawOffsetLabel;
    }
}
