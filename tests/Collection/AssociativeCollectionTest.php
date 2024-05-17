<?php declare(strict_types=1);

use Antares\Foundation\Collection\AssociativeCollection;
use Antares\Foundation\Collection\CollectionException;
use PHPUnit\Framework\TestCase;

final class AssociativeCollectionTest extends TestCase
{
    private function getStringCollection($unique = true, $acceptNulls = true)
    {
        $collection = new AssociativeCollection('string', $unique, $acceptNulls);
        $collection->add('a', 'apple');
        $collection->add('b', 'banana');
        $collection->add('c', 'carrot');
        return $collection;
    }

    public function testCollectionConstruct()
    {
        $types = explode(',', AssociativeCollection::VALID_TYPES);

        foreach ($types as $type) {
            $this->assertInstanceOf(AssociativeCollection::class, new AssociativeCollection($type));
            $this->assertInstanceOf(AssociativeCollection::class, new AssociativeCollection($type, true));
            $this->assertInstanceOf(AssociativeCollection::class, new AssociativeCollection($type, false, false));
        }
    }

    public function testExceptionForNotDefinedItemType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage('Item type not defined.');

        new AssociativeCollection('');
    }

    public function testExceptionForNonExistentType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Non existent type\:/');

        new AssociativeCollection('non_existent');
    }

    public function testExceptionForInvalidItemType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/The collection type .* cannot have item of type/');

        $collection = $this->getStringCollection();
        $collection->add('invalidType', []);
    }

    public function testExceptionForNoKeySupplied()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/No key supplied/');

        $collection = $this->getStringCollection();
        $collection->hasKey(null);
    }

    public function testExceptionForKeyNotFound()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Key not found\:/');

        $collection = $this->getStringCollection();
        $collection->hasKey(999, true);
    }

    public function testExceptionForAlreadyDefinedKey()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Already defined key\:/');

        $collection = $this->getStringCollection();
        $collection->add('b', 'banana');
    }

    public function testExceptionForItemNotFound()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Item not found\:/');

        $collection = $this->getStringCollection();
        $collection->hasItem('mango', true);
    }

    public function testExceptionForItemAlreadyExists()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Collection item already exists\:/');

        $collection = $this->getStringCollection();
        $collection->add('x', 'banana');
    }

    public function testNotUniqueCollection()
    {
        $collection = $this->getStringCollection(false);

        $collection->add('x', 'banana');
        $this->assertEquals($collection->count(), 4);
    }

    public function testAcceptNullItems()
    {
        $collection = new AssociativeCollection('mixed');

        $collection->add('x', 'banana');
        $collection->add('z', null);
        $this->assertEquals($collection->count(), 2);
    }

    public function testAssociativeStringCollection()
    {
        $collection = $this->getStringCollection();

        $this->assertInstanceOf(AssociativeCollection::class, $collection);

        $this->assertEquals($collection->count(), 3);

        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());

        $this->assertEquals($collection->getType(), 'string');

        $this->assertFalse($collection->isEmpty());

        $this->assertTrue($collection->isAssociative());

        $this->assertTrue($collection->isUnique());

        $this->assertTrue($collection->canAcceptNulls());

        $this->assertIsArray($collection->getData());

        $collection->clear();
        $this->assertEquals($collection->count(), 0);
        $collection = $this->getStringCollection();

        $this->assertIsArray($collection->toArray());

        $this->assertIsArray($collection->keys());

        $this->assertIsArray($collection->values());

        $this->assertTrue($collection->hasKey('b', false));

        $this->assertFalse($collection->hasKey('x', false));

        $this->assertTrue($collection->hasItem('banana'));

        $this->assertEquals($collection->getKey('banana'), 'b');

        $this->assertEquals($collection->getItem('b'), 'banana');

        $this->assertFalse($collection->hasItem('mango'));

        $collection->add('m', 'mango');
        $this->assertEquals($collection->count(), 4);

        $collection->addIfNotExists('b', 'banana');
        $this->assertEquals($collection->count(), 4);

        $collection->addIfNotExists('g', 'garlic');
        $this->assertEquals($collection->count(), 5);

        $collection->delete('m');
        $this->assertEquals($collection->count(), 4);

        $collection->deleteIfExists('o', 'onion');
        $this->assertEquals($collection->count(), 4);
    }
}
