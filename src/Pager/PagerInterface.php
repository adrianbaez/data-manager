<?php

namespace AdrianBaez\DataManager\Pager;

interface PagerInterface extends \IteratorAggregate, \Countable
{
    public function setPage(int $page);
    public function getPage(): int;
    public function setMaxPerPage(int $maxPerPage);
    public function getMaxPerPage(): int;
    public function getNbResults(): int;
    public function getLastPage(): int;
}