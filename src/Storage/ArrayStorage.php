<?php

namespace AdrianBaez\DataManager\Storage;

use AdrianBaez\DataManager\Pager\PagerInterface;
use AdrianBaez\DataManager\Pager\PagerAgregateInterface;
use AdrianBaez\DataManager\Pager\ArrayPager;

class ArrayStorage implements StorageInterface, \Countable, PagerAgregateInterface
{
    /**
     * @var array|\ArrayAccess $storage
     */
    private $storage = [];

    /**
     * @param array|\ArrayAccess $storage
     */
    public function __construct($storage = [])
    {
        $this->storage = $storage;
    }

    public function list()
    {
        return $this->storage;
    }

    public function create($data, $key = null)
    {
        if (null === $key) {
            $this->storage[] = $data;
            $keys = array_keys($this->storage);
            return end($keys);
        } else {
            $this->storage[$key] = $data;
            return $key;
        }
    }

    public function read($key)
    {
        return $this->storage[$key] ?? null;
    }

    public function update($key, $data)
    {
        $this->storage[$key] = $data;
    }

    public function delete($key)
    {
        unset($this->storage[$key]);
    }

    public function count()
    {
        return count($this->storage);
    }

    public function getPager(int $page = 0, int $maxPerPage = 0): PagerInterface
    {
        $pager = new ArrayPager($this->storage);
        $pager->setPage($page)
            ->setMaxPerPage($maxPerPage)
            ->initialize();
        return $pager;
    }
}
