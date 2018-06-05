<?php

namespace AdrianBaez\DataManager\Pager;

interface PagerAgregateInterface
{
    public function getPager(): PagerInterface;
}