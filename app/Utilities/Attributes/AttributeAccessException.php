<?php
namespace App\Utilities\Attributes;

/**
 * AttributeAccessException
 *   
 * @author Fox
 * Logs:
 *      - Implement codes for setAttributes, getAttributes, getAttribute, setAttribute
 * Updated at: 2023-10-12
 */

class AttributeAccessException extends \Exception {

    protected $attributeName;

    public function __construct($attributeName, $message = "", $code = 0, Throwable $previous = null) {
        $this->attributeName = $attributeName;
        if (empty($message)) {
            $message = "Attribute '$attributeName' is not accessible.";
        }
        parent::__construct($message, $code, $previous);
    }

    public function getAttributeName() {
        return $this->attributeName;
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
