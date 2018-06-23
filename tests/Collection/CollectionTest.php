<?php

namespace AdrianBaez\DataManager\Tests\Collection;

use PHPUnit\Framework\TestCase;
use AdrianBaez\DataManager\Collection\Collection;
use AdrianBaez\DataManager\IdentificableInterface;

class CollectionTest extends TestCase
{
    /**
     * @var Collection $collection
     */
    private $collection;

    public function setUp()
    {
        $this->collection = new Collection;
    }

    public function testAddHasGetRemove()
    {
        $foo = $this->createMock(IdentificableInterface::class);
        $foo->method('getId')->willReturn('foo');

        $this->assertFalse($this->collection->has('foo'));

        $this->collection->add($foo);
        $this->assertTrue($this->collection->has('foo'));

        $this->assertSame($foo, $this->collection->get('foo'));

        $this->collection->remove('foo');
        $this->assertFalse($this->collection->has('foo'));
    }

    /**
     * @expectedException AdrianBaez\DataManager\Exceptions\NotFoundException
     * @expectedExceptionMessage Item with id "baz" not found, available ids are "foo, bar"
     */
    public function testGetException()
    {
        $foo = $this->createMock(IdentificableInterface::class);
        $foo->method('getId')->willReturn('foo');

        $bar = $this->createMock(IdentificableInterface::class);
        $bar->method('getId')->willReturn('bar');

        $this->collection->add($foo);
        $this->collection->add($bar);

        $this->collection->get('baz');
    }
}
