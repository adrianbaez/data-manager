<?php

namespace AdrianBaez\DataManager\Storage;

interface StorageInterface
{
    public function list();
    public function create($data, $key = null);
    public function read($key);
    public function update($key, $data);
    public function delete($key);
}
