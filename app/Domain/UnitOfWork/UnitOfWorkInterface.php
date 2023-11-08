<?php
// Merged

namespace App\Domain\UnitOfWork;

interface UnitOfWorkInterface{
    /**
     * Start to work
     *
     * @return void
     */
    function begin();
    /**
     * Commit
     *
     * @return UnitOfWorkInterface
     */
    function commit();
    /**
     * Rollback
     *
     * @return UnitOfWorkInterface
     */
    function rollBack();
 }