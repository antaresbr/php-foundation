<?php declare(strict_types=1);

use Antares\Foundation\CurrentEnv;
use Antares\Foundation\Str;
use PHPUnit\Framework\TestCase;

final class CurrentEnvTest extends TestCase
{
    public function testNewCurrentenvObject()
    {
        $ce = new CurrentEnv();
        $this->assertInstanceOf(CurrentEnv::class, $ce);
    }

    public function testStaticMakeMethod()
    {
        $ce = CurrentEnv::make();
        $this->assertInstanceOf(CurrentEnv::class, $ce);
    }

    public function testCurrentenvConsistency()
    {
        $_ENV['ek1'] = 'ev1';
        $_SERVER['sk1'] = 'sv1';

        $ce = CurrentEnv::make();
        $this->assertInstanceOf(CurrentEnv::class, $ce);
        $this->assertEquals(getenv(), $ce->osenv()->toArray());
        $this->assertEquals($_ENV, $ce->ENV()->toArray());
        $this->assertEquals($_SERVER, $ce->SERVER()->toArray());

        $this->assertNotEquals($ce->osenv()->toArray(), $ce->ENV()->toArray());
        $this->assertNotEquals($ce->osenv()->toArray(), $ce->SERVER()->toArray());
        $this->assertNotEquals($ce->ENV()->toArray(), $ce->SERVER()->toArray());

        unset($_ENV['ek1']);
        unset($_SERVER['sk1']);
    }

    public function testResetToThisMethod()
    {
        $ce1 = CurrentEnv::make();

        putenv('ok1=ov1');
        $_ENV['ek1'] = 'ev1';
        $_SERVER['sk1'] = 'sv1';
        $ce2 = CurrentEnv::make();

        $this->assertNotEquals($ce1->osenv()->toArray(), $ce2->osenv()->toArray());
        $this->assertNotEquals($ce1->ENV()->toArray(), $ce2->ENV()->toArray());
        $this->assertNotEquals($ce1->SERVER()->toArray(), $ce2->SERVER()->toArray());

        $ce1->resetToThis();
        $this->assertEquals(getenv(), $ce1->osenv()->toArray());
        $this->assertEquals($_ENV, $ce1->ENV()->toArray());
        $this->assertEquals($_SERVER, $ce1->SERVER()->toArray());

        $ce2->resetToThis();
        $this->assertEquals(getenv(), $ce2->osenv()->toArray());
        $this->assertEquals($_ENV, $ce2->ENV()->toArray());
        $this->assertEquals($_SERVER, $ce2->SERVER()->toArray());
    }
}
