<?php declare(strict_types=1);

use Antares\Foundation\Collection\CollectionException;
use Antares\Foundation\Collection\SimpleCollection;
use PHPUnit\Framework\TestCase;

final class SimpleCollectionTest extends TestCase
{
    private function getStringCollection($unique = true, $acceptNulls = true)
    {
        $collection = new SimpleCollection('string', $unique, $acceptNulls);
        $collection->add('apple');
        $collection->add('banana');
        $collection->add('carrot');
        return $collection;
    }

    public function testCollectionConstruct()
    {
        $types = explode(',', SimpleCollection::VALID_TYPES);

        foreach ($types as $type) {
            $this->assertInstanceOf(SimpleCollection::class, new SimpleCollection($type));
            $this->assertInstanceOf(SimpleCollection::class, new SimpleCollection($type, true));
            $this->assertInstanceOf(SimpleCollection::class, new SimpleCollection($type, false, false));
        }
    }

    public function testExceptionForNotDefinedItemType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage('Item type not defined.');

        new SimpleCollection('');
    }

    public function testExceptionForNonExistentType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Non existent type\:/');

        new SimpleCollection('non_existent');
    }

    public function testExceptionForInvalidItemType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/The collection type .* cannot have item of type/');

        $collection = $this->getStringCollection();
        $collection->add([]);
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
        $collection->add('banana');
    }

    public function testNotUniqueCollection()
    {
        $collection = $this->getStringCollection(false);

        $collection->add('banana');
        $this->assertEquals($collection->count(), 4);
    }

    public function testAcceptNullItems()
    {
        $collection = new SimpleCollection('mixed');

        $collection->add('banana');
        $collection->add(null);
        $this->assertEquals($collection->count(), 2);
    }

    public function testSimpleStringCollection()
    {
        $collection = $this->getStringCollection();

        $this->assertInstanceOf(SimpleCollection::class, $collection);

        $this->assertEquals($collection->count(), 3);

        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());

        $this->assertEquals($collection->getType(), 'string');

        $this->assertFalse($collection->isEmpty());

        $this->assertFalse($collection->isAssociative());

        $this->assertTrue($collection->isUnique());

        $this->assertTrue($collection->canAcceptNulls());

        $this->assertIsArray($collection->getData());

        $collection->clear();
        $this->assertEquals($collection->count(), 0);
        $collection = $this->getStringCollection();

        $this->assertIsArray($collection->toArray());

        $this->assertIsArray($collection->keys());

        $this->assertIsArray($collection->values());

        $this->assertTrue($collection->hasKey(1, false));

        $this->assertFalse($collection->hasKey(999, false));

        $this->assertTrue($collection->hasItem('banana'));

        $this->assertEquals($collection->getKey('banana'), 1);

        $this->assertEquals($collection->getItem(1), 'banana');

        $this->assertFalse($collection->hasItem('mango'));

        $collection->add('mango');
        $this->assertEquals($collection->count(), 4);

        $collection->insert('tomato', 1);
        $this->assertEquals($collection->count(), 5);
        $this->assertEquals($collection->getKey('banana'), 2);

        $collection->addIfNotExists('banana');
        $this->assertEquals($collection->count(), 5);

        $collection->addIfNotExists('garlic');
        $this->assertEquals($collection->count(), 6);

        $collection->delete('tomato');
        $this->assertEquals($collection->count(), 5);

        $collection->deleteIfExists('onion');
        $this->assertEquals($collection->count(), 5);

        $collection->clear();
        $this->assertEquals($collection->count(), 0);
        $collection = $this->getStringCollection();

        $this->assertIsArray($collection->toArray());
    }
}
