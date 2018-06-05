<?php

namespace AdrianBaez\DataManager;

interface FiltrableInterface
{
    public function applyFilter($key, $value);
}