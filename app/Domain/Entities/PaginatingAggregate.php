<?php 
//merged
namespace App\Domain\Entities;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\AccessorOrder;
use JMS\Serializer\Annotation as Serializer;

/**
 * @AccessorOrder("custom", custom =　{"meta", "items"})
 */
class PaginatingAggregate{
    /**
     * @SerializedName("items") 
     * @Serializer\Groups({"detail", "simple", "list"}) 
     *
     * @var array
     */
    protected array $items = [];

    /**
     * @SerializedName("meta")
     * @Serializer\Groups({"detail", "simple", "list"})  
     *
     * @var MetaData
     */
    protected MetaData $meta;

    public function __construct($items, $total, $perPage, $currentPage = null){
        if(is_null($items)) $items = [];
        $this->items = $items;
        $this->setMeta(new MetaData($total, $perPage, $currentPage));
    }
    /**
     * Get the value of items
     *
     * @return  array
     */ 
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the value of items
     *
     * @param  array  $items
     *
     * @return  self
     */ 
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * Get the value of meta
     *
     * @return  MetaData
     */ 
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set the value of meta
     *
     * @param  MetaData  $meta
     *
     * @return  self
     */ 
    public function setMeta(MetaData $meta)
    {
        $this->meta = $meta;
    }

    public function hasItems(){
        return ($this->items) && count($this->items) > 0;
    }
}