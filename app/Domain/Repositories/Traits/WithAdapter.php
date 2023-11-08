<?php
namespace App\Domain\Repositories\Traits;
use App\Domain\Adapters\EntityAdapterInterface as EntityAdapter;

trait WithAdapter{

    /**
     * @var EntityAdapter The default adapter for converting models to entities.
     */
    private $defaultAdapter;

    /**
     * @var EntityAdapter|null The custom adapter for converting models to entities.
     */
    private $customAdapter;

    /**
     * Sets a custom adapter.
     *
     * @param EntityAdapter $adapter The custom adapter.
     * @return self
     */
    function withAdapter($adapter){
        $this->customAdapter = $adapter;
        return $this;
    }

    /**
     * Resets the adapter to the default adapter.
     * @return self
     */
    function resetAdapter(){
        $this->customAdapter = null;
        return $this;
    }

    /**
     * Retrieves the current adapter.
     *
     * @return EntityAdapter The current adapter (custom or default).
     */
    public function adapter(){
        return $this->customAdapter != null ? $this->customAdapter : $this->defaultAdapter;
    }
}