<?php declare(strict_types=1);

use Antares\Foundation\Timezone\Timezone;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class TimezoneTest extends TestCase
{
    #[Test]
    public function timezone_none()
    {
        $timezone = new Timezone('none');
        $this->assertInstanceOf(Timezone::class, $timezone);
        $this->assertInstanceOf(IntlTimeZone::class, $timezone->getIntance());
        $this->assertEquals('none', $timezone->getId());
        $this->assertEquals('GMT', $timezone->getName());
        $this->assertEquals(0, $timezone->getRawOffset());
        $this->assertEquals('UTC', $timezone->getRawOffsetLabel());
    }

    #[Test]
    #[TestDox('Timezone UTC')]
    public function timezone_utc()
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
    #[TestDox('Timezone pt-BR')]
    public function timezone_pt_BR()
    {
        $tz = 'America/Sao_Paulo';
        $timezone = new Timezone($tz);
        $this->assertInstanceOf(Timezone::class, $timezone);
        $this->assertInstanceOf(IntlTimeZone::class, $timezone->getIntance());
        $this->assertEquals($tz, $timezone->getId());
        $this->assertEquals('Brasilia Standard Time', $timezone->getName());
        $this->assertEquals(-10800000, $timezone->getRawOffset());
        $this->assertEquals('UTC-03:00', $timezone->getRawOffsetLabel());
    }
}
