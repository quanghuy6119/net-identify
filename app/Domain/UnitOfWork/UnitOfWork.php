<?php
//merged

namespace App\Domain\UnitOfWork;
use App\Domain\UnitOfWork\UnitOfWorkInterface;

class UnitOfWork implements UnitOfWorkInterface{
    use UnitOfWorkTrait;
}
