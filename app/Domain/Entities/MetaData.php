<?php 
//merged
namespace App\Domain\Entities;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\AccessorOrder;
use JMS\Serializer\Annotation as Serializer;
/**
 * @AccessorOrder("custom", custom = {"total", "perPage", "currentPage", "lastPage"})
 */
class MetaData{
    /** 
     * @SerializedName("currentPage") 
     * @Serializer\Groups({"detail", "simple", "list"}) 
    */
    protected $currentPage;

    /** 
     * @Serializer\Groups({"detail", "simple", "list"}) 
     * @SerializedName("lastPage") 
    */
    protected $lastPage;

    /**
     * @Serializer\Groups({"detail", "simple", "list"})  
     * @SerializedName("total") 
    */
    protected $total;

    /** 
     * @SerializedName("perPage") 
     * @Serializer\Groups({"detail", "simple", "list"}) 
    */
    protected $perPage;

    public function __construct($total, $perPage, $currentPage = null){
        $this->total = $total;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = $perPage === 0 ? 0 : max((int) ceil($total / $perPage), 1);
    }

    public static function create($total, $perPage, $currentPage = null){
        return new MetaData($total, $perPage, $currentPage = null);
    }

    public function getTotal(){
        return $this->total;
    }

    public function getPerPage(){
        return $this->perPage;
    }

    public function getCurrentPage(){
        return $this->currentPage;
    }
    public function getLastPage(){
        return $this->lastPage;
    }
}