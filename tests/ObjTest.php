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
}
