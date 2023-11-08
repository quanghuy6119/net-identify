<?php

namespace App\Services\Contracts;

interface SearchableInterface{
    public function search(array $conditions);
}