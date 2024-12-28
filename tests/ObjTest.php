<?php declare(strict_types=1);

use Antares\Foundation\Obj;
use Antares\Foundation\Tests\Resources\Dummy;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ObjTest extends TestCase
{
    #[Test]
    public function get_public_value()
    {
        $obj = new Dummy();
        $this->assertInstanceOf(Dummy::class, $obj);

        $prop = 'publicVar';
        $this->assertTrue(Obj::isPublic($obj, $prop));
        $this->assertEquals($obj->getPublicVar(), Obj::get($obj, $prop));
    }
    
    #[Test]
    public function get_protected_value()
    {
        $obj = new Dummy();
        $this->assertInstanceOf(Dummy::class, $obj);

        $prop = 'protectedVar';
        $this->assertTrue(Obj::isProtected($obj, $prop));
        $this->assertEquals($obj->getProtectedVar(), Obj::get($obj, $prop));
    }
    
    #[Test]
    public function get_private_value()
    {
        $obj = new Dummy();
        $this->assertInstanceOf(Dummy::class, $obj);

        $prop = 'privateVar';
        $this->assertTrue(Obj::isPrivate($obj, $prop));
        $this->assertEquals($obj->getPrivateVar(), Obj::get($obj, $prop));
    }

    #[Test]
    public function set_public_value()
    {
        $obj = new Dummy();
        $this->assertInstanceOf(Dummy::class, $obj);
        
        $prop = 'publicVar';
        $old = Obj::get($obj, $prop);
        $new = "changed {$old}";
        Obj::set($obj, $prop, $new);
        
        $this->assertEquals($new, $obj->getPublicVar());
        $this->assertEquals($new, Obj::get($obj, $prop));
    }

    #[Test]
    public function set_protected_value()
    {
        $obj = new Dummy();
        $this->assertInstanceOf(Dummy::class, $obj);
        
        $prop = 'protectedVar';
        $old = Obj::get($obj, $prop);
        $new = "changed {$old}";
        Obj::set($obj, $prop, $new);
        
        $this->assertEquals($new, $obj->getProtectedVar());
        $this->assertEquals($new, Obj::get($obj, $prop));
    }

    #[Test]
    public function set_private_value()
    {
        $obj = new Dummy();
        $this->assertInstanceOf(Dummy::class, $obj);
        
        $prop = 'privateVar';
        $old = Obj::get($obj, $prop);
        $new = "changed {$old}";
        Obj::set($obj, $prop, $new);
        
        $this->assertEquals($new, $obj->getPrivateVar());
        $this->assertEquals($new, Obj::get($obj, $prop));
    }

    #[Test]
    public function get_public_static_value()
    {
        $prop = 'publicStaticVar';
        $this->assertTrue(Obj::isPublic(Dummy::class, $prop));
        $this->assertEquals(Dummy::getPublicStaticVar(), Obj::get(Dummy::class, $prop));
    }

    #[Test]
    public function get_protected_static_value()
    {
        $prop = 'protectedStaticVar';
        $this->assertTrue(Obj::isProtected(Dummy::class, $prop));
        $this->assertEquals(Dummy::getProtectedStaticVar(), Obj::get(Dummy::class, $prop));
    }

    #[Test]
    public function get_private_static_value()
    {
        $prop = 'privateStaticVar';
        $this->assertTrue(Obj::isPrivate(Dummy::class, $prop));
        $this->assertEquals(Dummy::getPrivateStaticVar(), Obj::get(Dummy::class, $prop));
    }

    #[Test]
    public function set_public_static_value()
    {
        $prop = 'publicStaticVar';
        $old = Obj::get(Dummy::class, $prop);
        $new = "changed {$old}";
        Obj::set(Dummy::class, $prop, $new);
        
        $this->assertEquals($new, Dummy::getPublicStaticVar());
        $this->assertEquals($new, Obj::get(Dummy::class, $prop));
    }

    #[Test]
    public function set_protected_static_value()
    {
        $prop = 'protectedStaticVar';
        $old = Obj::get(Dummy::class, $prop);
        $new = "changed {$old}";
        Obj::set(Dummy::class, $prop, $new);
        
        $this->assertEquals($new, Dummy::getProtectedStaticVar());
        $this->assertEquals($new, Obj::get(Dummy::class, $prop));
    }

    #[Test]
    public function set_private_static_value()
    {
        $prop = 'privateStaticVar';
        $old = Obj::get(Dummy::class, $prop);
        $new = "changed {$old}";
        Obj::set(Dummy::class, $prop, $new);
        
        $this->assertEquals($new, Dummy::getPrivateStaticVar());
        $this->assertEquals($new, Obj::get(Dummy::class, $prop));
    }

    #[Test]
    public function safe_method_call()
    {
        $obj = new Dummy();
        $this->assertEquals($obj->getPublicVar(), Obj::safeCall($obj, 'getPublicVar'));
        $this->assertEquals($obj->getProtectedVar(), Obj::safeCall($obj, 'getProtectedVar'));
        $this->assertEquals($obj->getPrivateVar(), Obj::safeCall($obj, 'getPrivateVar'));
    }

    #[Test]
    public function safe_method_call_with_args()
    {
        $args = ['alfa', 'beta', 'gama'];
        $obj = new Dummy();
        $this->assertEquals($obj->getPublicVar(...$args), Obj::safeCall($obj, 'getPublicVar', $args));
        $this->assertEquals($obj->getProtectedVar(...$args), Obj::safeCall($obj, 'getProtectedVar', $args));
        $this->assertEquals($obj->getPrivateVar(...$args), Obj::safeCall($obj, 'getPrivateVar', $args));
    }

    #[Test]
    public function safe_static_method_call()
    {
        $this->assertEquals(Dummy::getPublicStaticVar(), Obj::safeCall(Dummy::class, 'getPublicStaticVar'));
        $this->assertEquals(Dummy::getProtectedStaticVar(), Obj::safeCall(Dummy::class, 'getProtectedStaticVar'));
        $this->assertEquals(Dummy::getPrivateStaticVar(), Obj::safeCall(Dummy::class, 'getPrivateStaticVar'));
    }

    #[Test]
    public function safe_static_method_call_with_args()
    {
        $args = ['alfa', 'beta', 'gama'];
        $this->assertEquals(Dummy::getPublicStaticVar(...$args), Obj::safeCall(Dummy::class, 'getPublicStaticVar', $args));
        $this->assertEquals(Dummy::getProtectedStaticVar(...$args), Obj::safeCall(Dummy::class, 'getProtectedStaticVar', $args));
        $this->assertEquals(Dummy::getPrivateStaticVar(...$args), Obj::safeCall(Dummy::class, 'getPrivateStaticVar', $args));
    }
}
