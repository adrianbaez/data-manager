<?php

namespace AdrianBaez\DataManager\Tests\Storage;

use PHPUnit\Framework\TestCase;
use AdrianBaez\DataManager\Storage\ArrayStorage;
use AdrianBaez\DataManager\Pager\PagerInterface;

class ArrayStorageTest extends TestCase
{
    public function testList()
    {
        $data = ['foo' => 'fooValue', 'bar' => 'barValue'];
        $storage = new ArrayStorage($data);

        $this->assertEquals($data, $storage->list());
    }

    /**
     * @dataProvider getTestCreate
     */
    public function testCreate(ArrayStorage $storage, $expectedKey, $value, $key = null)
    {
        $lastKey = $storage->create($value, $key);
        $this->assertSame($expectedKey, $lastKey);
        $this->assertSame($value, $storage->read($expectedKey));
    }

    public function getTestCreate()
    {
        $storage = new ArrayStorage(['foo' => 'fooValue']);
        // storage, expectedKey, value, key = null

        yield [$storage, 0, 'bar'];
        yield [$storage, 1, 'baz'];
        yield [$storage, 'qux', 'quxValue', 'qux'];
        yield [$storage, 'quux', 'quuxValue', 'quux'];
    }

    /**
     * @dataProvider getTestRead
     */
    public function testRead(ArrayStorage $storage, $key, $value)
    {
        $this->assertSame($value, $storage->read($key));
    }

    public function getTestRead()
    {
        $storage = new ArrayStorage([
            'foo' => 'fooValue',
            'bar',
            ]);
        // storage, key, value

        yield [$storage, 'foo', 'fooValue'];
        yield [$storage, 0, 'bar'];
        yield [$storage, 'baz', null];
    }

    /**
     * @dataProvider getTestUpdate
     */
    public function testUpdate(ArrayStorage $storage, $key, $value)
    {
        $storage->update($key, $value);
        $this->assertSame($value, $storage->read($key));
    }

    public function getTestUpdate()
    {
        $storage = new ArrayStorage([
            'foo' => 'fooValue',
            'bar',
            ]);
        // storage, key, value

        yield [$storage, 'foo', 'fooValueModified'];
        yield [$storage, 0, 'barModified'];
        yield [$storage, 'baz', 'bazValue'];
    }

    public function testDelete()
    {
        $storage = new ArrayStorage([
            'foo' => 'fooValue',
            ]);

        $storage->delete('foo');
        $this->assertNull($storage->read('foo'));
    }

    public function testCount()
    {
        $storage = new ArrayStorage();

        $this->assertCount(0, $storage);

        $storage->create('foo');

        $this->assertCount(1, $storage);
    }

    /**
     * @dataProvider getPager
     */
    public function testGetPager(array $data, int $page, int $maxPerPage, array $inPage)
    {
        $storage = new ArrayStorage($data);
        $pager = $storage->getPager($page, $maxPerPage);

        $this->assertInstanceOf(PagerInterface::class, $pager);

        $this->assertEquals($inPage, iterator_to_array($pager));
    }

    public function getPager()
    {
        $data = range(1, 10);
        // data, page, maxPerPage, inPage
        yield [$data, 0, 0, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];
        yield [$data, 2, 3, [4, 5, 6]];
    }
}
