<?php

namespace App\Domain\UnitOfWork;
use Illuminate\Support\Facades\DB;

trait UnitOfWorkTrait{
    private bool $isInTransaction = false;
    /**
     * Start a new transaction
     *
     * @return void
     */
    public function begin(){
        DB::beginTransaction();
        $this->isInTransaction = true;
    }
    /**
     * Rollback
     *
     * @return void
     */
    public function rollBack(){
        if(!$this->isInTransaction) return $this;
        DB::rollback();
        $this->isInTransaction= false;
    }
    /**
     * Commit
     *
     * @return void
     */
    public function commit(){
        if(!$this->isInTransaction) return $this;
        DB::commit();
        $this->isInTransaction= false;
    }
    /**
     * Rollback if not commited
     */
    function __destruct()
    {
        if($this->isInTransaction){
            $this->rollBack();
        }
    }
}
