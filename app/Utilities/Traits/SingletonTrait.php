<?php
namespace App\Utilities\Traits;

/**
 * SingletonTrait
 *
 * This trait provides a template for implementing the Singleton pattern in PHP.
 * It can be used in a class to ensure that only one instance of the class is created.
 *
 * @author Fox
 * 
 */
trait SingletonTrait{
    
    private static $instance;
    
    public static function getInstance(){
        if (isset(self::$instance)) return self::$instance;
        self::$instance = new self();
        return self::$instance;
    }
     // Private constructor to prevent direct instantiation
    private function __construct() {

    }

    // Private clone method to prevent cloning of the instance
    private function __clone() {
    }

    // Private unserialize method to prevent unserializing of the instance
    private function __wakeup() {
    }
}