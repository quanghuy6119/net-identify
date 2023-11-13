<?php
namespace App\Domain\Entities;

use App\Domain\Entities\ModelMappingException as EntitiesMappingException;
use App\Utilities\Attributes\AttributeAccessorTrait;
use JMS\Serializer\Annotation as Serializer;

abstract class Entity{
    use AttributeAccessorTrait;

    /**
     * Identity of the entity
     * @Serializer\Groups({"entity.id", "detail", "simple", "list"})
     * @Serializer\SerializedName("id")
     */
    protected $id;

    /**
     * Get value of id
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Set id value
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }
}
