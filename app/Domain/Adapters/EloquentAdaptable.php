<?php
namespace App\Domain\Adapters;

interface EloquentAdaptable{
    function toEloquent($entity);
    function toNewEloquent($entity);
}