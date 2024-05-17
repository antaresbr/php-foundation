<?php declare(strict_types=1);

use Antares\Foundation\ArrayedObject;
use PHPUnit\Framework\TestCase;

final class ArrayedObjectTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(ArrayedObject::class, new ArrayedObject());
    }

    public function testCount()
    {
        $ao = new ArrayedObject();
        $this->assertCount(0, $ao);
    }

    public function testSetup()
    {
        $ao = new ArrayedObject();

        $ao->setup(['k1' => 'v1', 'k2' => 'v2']);
        $this->assertCount(2, $ao);

        $ao->setup();
        $this->assertCount(0, $ao);
    }

    public function testAll()
    {
        $ao = new ArrayedObject();

        $this->assertCount(0, $ao->all());
        $ao->setup(['k1' => 'v1', 'k2' => 'v2']);
        $this->assertCount(2, $ao->all());
    }

    public function testToArray()
    {
        $ao = new ArrayedObject();

        $ao->setup(['k1' => 'v1', 'k2' => 'v2']);
        $this->assertIsArray($ao->toArray());
        $this->assertCount(2, $ao->toArray());
    }

    public function testIsEmpty()
    {
        $ao = new ArrayedObject();

        $this->assertEmpty($ao);
        $ao->setup(['k1' => 'v1', 'k2' => 'v2']);
        $this->assertNotEmpty($ao);
    }

    public function testHas()
    {
        $ao = new ArrayedObject();

        $this->assertFalse($ao->has('k1'));
        $ao->setup(['k1' => 'v1', 'k2' => 'v2']);
        $this->assertIsString($ao['k1']);
    }

    public function testSetAndGet()
    {
        $ao = new ArrayedObject();

        $ao->set('k1', 'v1');
        $this->assertIsString($ao->get('k1'));
        
        $this->assertFalse(isset($ao->k2));
        $ao->k2 = 'v2';
        $this->assertTrue(isset($ao->k2));
        $this->assertIsString($ao->k2);
        
        $this->assertFalse(isset($ao['k3']));
        $ao['k3'] = 'v3';
        $this->assertTrue(isset($ao['k3']));
        $this->assertIsString($ao['k3']);

        $this->assertCount(3, $ao);
    }

    public function testForget()
    {
        $ao = new ArrayedObject();

        $ao->set('k1', 'v1');
        $this->assertIsString($ao['k1']);
        
        $ao->forget('k1');
        $this->assertFalse($ao->has('k1'));
    }

    public function testIsSet()
    {
        $ao = new ArrayedObject();

        $this->assertFalse(isset($ao['k1']));
        $this->assertFalse(isset($ao->k1));
        $ao->set('k1', 'v1');
        $this->assertTrue(isset($ao['k1']));
        $this->assertTrue(isset($ao->k1));
    }

    public function testArrayAccess()
    {
        $ao = new ArrayedObject();

        $this->assertFalse(isset($ao['k1']));
        $ao['k1'] = 'v1';
        $this->assertTrue(isset($ao['k1']));
        $ao[] = 'v2';
        $ao[] = 'v3';
        $ao[] = 'v4';
        $this->assertTrue(isset($ao[1]));
        $this->assertEquals($ao[1], 'v3');
        unset($ao[1]);
        $this->assertFalse(isset($ao[1]));
    }

    public function testSerialization()
    {
        $ao1 = new ArrayedObject();
        $ao1->setup(['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3']);

        $ao2 = new ArrayedObject();
        $ao2->setup(unserialize($ao1->serialize()));
        $this->assertInstanceOf(ArrayedObject::class, $ao2);
        $this->assertFalse($ao1 === $ao2);
        $this->assertEquals($ao1, $ao2);
        $this->assertEquals($ao1->count(), $ao2->count());
        $ao2->k2 = 'x2';
        $this->assertNotEquals($ao1->k2, $ao2->k2);
    }

    public function testJsonSerialization()
    {
        $ao1 = new ArrayedObject();
        $ao1->setup(['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3']);
        $jo1 = json_encode($ao1);
        $this->assertJson($jo1);

        $jo2 = json_decode($jo1, true);
        $this->assertIsArray($jo2);
        $this->assertEquals($ao1->jsonSerialize(), $jo2);
        $this->assertEquals($ao1->k2, $jo2['k2']);
        $this->assertEquals($ao1->count(), count($jo2));
        $jo2['k7'] = 'x7';
        $this->assertNotEquals($ao1->count(), count($jo2));
    }
}
