<?php

namespace App\Utilities\Serializer;

use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Context;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\Handler\SubscribingHandlerInterface;

class CustomJmsHandler{
    /**
     * Type of object will handle
     *
     * @var string
     */
    private string $type;

    private \Closure $callback;

    public int $direction;

    public function __construct(string $type, 
                                \Closure $callback,
                                int $direction = GraphNavigator::DIRECTION_SERIALIZATION){
        
        $this->type = $type;
        $this->callback = $callback;
        $this->direction = $direction;
    }
    public function getType(){
        return $this->type ?? null;
    }
    public function getCallback(){
        return $this->callback ?? null;
    }
    public function getDirection(){
        return $this->direction;
    } 
}