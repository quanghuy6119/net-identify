<?php
namespace App\Domain\Adapters;

interface EntityAdaptable{
    function toEntity($entity);
}