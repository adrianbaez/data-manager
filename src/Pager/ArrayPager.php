<?php

namespace AdrianBaez\DataManager\Pager;

class ArrayPager implements PagerInterface
{
    use PagerTrait;

    /**
     * @var array $storage
     */
    private $storage = [];

    public function __construct(array $storage = [])
    {
        $this->storage = $storage;
    }

    public function initialize()
    {
        $this->setNbResults(count($this->storage));

        return $this;
    }

    public function getIterator()
    {
        $from = 0;
        $to = $count = count($this->storage);

        if ($this->maxPerPage > 0) {
            $from = ($this->page - 1) * $this->maxPerPage;
            $to = min($count, $from + $this->maxPerPage);
        }

        for ($i = $from; $i < $to; $i++) {
            yield $this->storage[$i];
        }
    }
}
