<?php
namespace App\Utilities\Serializer;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use App\Utilities\Serializer\ContextType;
use App\Utilities\Serializer\NotExeptExclusionStrategy;
use App\Utilities\Serializer\ExceptExclusionStrategy;
use JMS\Serializer\Exclusion\GroupsExclusionStrategy;
use JMS\Serializer\SerializerBuilder;
use App\Utilities\Serializer\Exceptions\SerializerException;
use JMS\Serializer\Handler\HandlerRegistry;

class FlexibleSerializer{
    
    private string $contextType;

    private ?JMSSerializer $jmsSerializer;

    private ?ExclusionStrategyInterface $exclusionStrategy; 

    private $data;
    
    private array $exceptProperties;

    public array $onlyProperties;

    public array $groups; 

    private bool $skipNullValue = false;

    private array $customJmsHandlers = [];

    public function __construct(){
       $this->contextType = ContextType::DEFAULT; 
       $this->jmsSerializer = null;
    }
    public function with($data){
        $this->data = $data;
        return $this;
    }
    public function all(){
        $this->contextType = ContextType::ALL;
        return $this;
    }

    /**
     * Get only properties
     *
     * @param array $properties
     * @return self
     */
    public function only(array $properties){
        $this->onlyProperties = $properties;
        $this->contextType = ContextType::ONLY;
        return $this;
    }

     /**
     * get by groups
     *
     * @param array $properties
     * @return self
     */
    public function groups(array $groups){
        $this->groups = $groups;
        $this->contextType = ContextType::GROUP;
        return $this;
    }

     /**
     * get except
     *
     * @param array $properties
     * @return self
     */
    public function except(array $properties){
        $this->exceptProperties = $properties;
        $this->contextType = ContextType::EXCEPT;
        return $this;
    }
     /**
     * get array
     *
     * @param array $properties
     * @return self
     * @throws SerializerException
     */
    public function getArray(): array{
        $this->build();
        if($this->data === null){
            throw new SerializerException("Data is must be not null");
        }
        return $this->jmsSerializer->toArray($this->data);
    }
    /**
     * Get json
     *
     * @return Json
     * @throws SerializerException
     */
    public function getJson(){
        $this->build();
        if($this->data == null){
            throw new SerializerException("Data is must be not null");
        }
        return $this->jmsSerializer->serialize($this->data, 'json');
    }

    public function allowSkipNullValue($skip = false){
       $this->skipNullValue = $skip; 
    }

    /**
     * Build a serializer base on this builder
     *
     * @return void
     */
    private function build(){
        $this->exclusionStrategy = $this->specifyExclusionStrategy();
        $context = SerializationContext::create()->setSerializeNull(!$this->skipNullValue);
        if($this->exclusionStrategy !== null){
            $context->addExclusionStrategy($this->exclusionStrategy);
        }
        $builder = SerializerBuilder::create()->setSerializationContextFactory(function () use($context) {
            return $context;
        });
        
        $builder->addDefaultHandlers()
                ->configureHandlers(function(HandlerRegistry $registry) {
                if(count($this->customJmsHandlers) > 0){
                    
                    foreach($this->customJmsHandlers as $handler){
                        $registry->registerHandler($handler->getDirection(), $handler->getType(), 'json',
                            function($visitor, $obj, array $type) use($handler){ 
                                $callback = $handler->getCallback();
                                return $callback($obj);
                            }
                        ); 
                    }
                }
            });
        $this->jmsSerializer = $builder->build();
    }
    
    public function pushHandler(CustomJmsHandler $customHander){
        $this->customJmsHandlers[] = $customHander;
        return $this;
    }

    /**
     * Specify strategy for exclusion
     *
     */
    public function specifyExclusionStrategy(){
        switch ($this->contextType){
            case ContextType::ALL :
                return new ExceptExclusionStrategy([]);
            case ContextType::ONLY :
                return new NotExeptExclusionStrategy($this->onlyProperties); 
            case ContextType::EXCEPT :
                return new ExceptExclusionStrategy($this->exceptProperties); 
            case ContextType::GROUP:
                return new GroupsExclusionStrategy($this->groups);
            case ContextType::DEFAULT:
                return null;
        }
        return null;
    }
}