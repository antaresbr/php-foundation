<?php declare(strict_types=1);

use Antares\Foundation\Obj;
use Antares\Foundation\Timezone\Timezone;
use Antares\Foundation\Timezone\Timezones;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class TimezonesTest extends TestCase
{
    private function ensure_config_function() {
        if (!function_exists('config')) {
            function config(?string $key): mixed
            {
                return 'America/Sao_Paulo';
            }
        }
    }

    public function assert_timezone_america_sao_paulo(Timezone $timezone): void
    {
        $tz = 'America/Sao_Paulo';
        $this->assertInstanceOf(Timezone::class, $timezone);
        $this->assertInstanceOf(IntlTimeZone::class, $timezone->getIntance());
        $this->assertEquals($tz, $timezone->getId());
        $this->assertEquals('Brasilia Standard Time', $timezone->getName());
        $this->assertEquals(-10800000, $timezone->getRawOffset());
        $this->assertEquals('UTC-03:00', $timezone->getRawOffsetLabel());
    }

    #[Test]
    #[TestDox('Default timezone (America/Sao_Paulo)')]
    public function timezones_default()
    {
        $this->ensure_config_function();
        
        $timezone = Timezones::timezone();
        $this->assert_timezone_america_sao_paulo($timezone);
    }

    #[Test]
    public function timezones_none()
    {
        $tz = 'none';
        $timezone = Timezones::timezone($tz);
        $this->assertInstanceOf(Timezone::class, $timezone);
        $this->assertInstanceOf(IntlTimeZone::class, $timezone->getIntance());
        $this->assertEquals($tz, $timezone->getId());
        $this->assertEquals('GMT', $timezone->getName());
        $this->assertEquals(0, $timezone->getRawOffset());
        $this->assertEquals('UTC', $timezone->getRawOffsetLabel());
    }

    #[Test]
    #[TestDox('Timezone UTC')]
    public function timezones_utc()
    {
        $tz = 'UTC';
        $timezone = new Timezone($tz);
        $this->assertInstanceOf(Timezone::class, $timezone);
        $this->assertInstanceOf(IntlTimeZone::class, $timezone->getIntance());
        $this->assertEquals($tz, $timezone->getId());
        $this->assertEquals('Coordinated Universal Time', $timezone->getName());
        $this->assertEquals(0, $timezone->getRawOffset());
        $this->assertEquals('UTC', $timezone->getRawOffsetLabel());
    }

    #[Test]
    #[TestDox('Timezone America/Sao_Pautlo')]
    public function timezones_america_sao_paulo()
    {
        $timezone = new Timezone('America/Sao_Paulo');
        $this->assert_timezone_america_sao_paulo($timezone);
    }

    #[Test]
    #[TestDox('Count Timezones::timezones array')]
    public function timezones_count()
    {
        //-- valid timezone objects
        $this->assertEquals(2, count(Obj::get(Timezones::class, 'timezones')));
    }
}
