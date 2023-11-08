<?php
namespace App\Utilities\Traits;

use App\Utilities\Serializer\FlexibleSerializer;

trait SerializationTrait{  
     /**
     * Get a Serializer
     *
     * @return FlexibleSerializer
     */
    public function serializer(){
        return $this->resolve(FlexibleSerializer::class);
    }
}
