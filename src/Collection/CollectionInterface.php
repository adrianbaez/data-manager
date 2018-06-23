<?php

namespace AdrianBaez\DataManager\Collection;

use AdrianBaez\DataManager\IdentificableInterface;

interface CollectionInterface
{
    public function add(IdentificableInterface $item);
    public function has($key): bool;
    public function get($key);
    public function remove($key);
}
