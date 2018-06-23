<?php

namespace AdrianBaez\DataManager\Collection;

use AdrianBaez\DataManager\Exceptions\NotFoundException;
use AdrianBaez\DataManager\IdentificableInterface;

class Collection implements CollectionInterface
{
    private $items = [];

    public function add(IdentificableInterface $item)
    {
        $this->items[$item->getId()] = $item;
    }

    public function has($id): bool
    {
        return isset($this->items[$id]);
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException(sprintf('Item with id "%s" not found, available ids are "%s"', $id, implode(', ', array_keys($this->items))));
        }
        return $this->items[$id];
    }

    public function remove($id)
    {
        unset($this->items[$id]);
    }
}
