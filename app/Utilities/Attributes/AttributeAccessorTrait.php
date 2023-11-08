<?php
namespace App\Utilities\Attributes;
use App\Utilities\Attributes\AttributeAccessException;

/**
 * Supports methods for set and get value to objects by attribute
 *   
 * @author Fox
 * Logs:
 *      - Implement codes for setAttributes, getAttributes, getAttribute, setAttribute
 * Updated at: 2023-10-12
 */
trait AttributeAccessorTrait {

    /**
     * Set values.
     *
     * @param array $attributes An associative array where the keys represent attribute names and the values are the corresponding values.
     *
     * @throws AttributeAccessException if a setter method for any attribute does not exist.
     */
    public function setAttributes(array $attributes) {
        foreach ($attributes as $attributeName => $value) {
            $this->setAttribute($attributeName, $value);
        }
    }

    /**
     * Get values.
     *
     * @param array $attributeNames An array of attribute names to retrieve.
     *
     * @return array An associative array where the keys represent attribute names and the values are the corresponding attribute values.
     *
     * @throws AttributeAccessException if a getter method for any attribute does not exist.
     */
    public function getAttributes(array $attributeNames) {
        $result = [];

        foreach ($attributeNames as $attributeName) {
            $result[$attributeName] = $this->getAttribute($attributeName);
        }

        return $result;
    }

    /**
     * Set the value of an object's attribute using the attribute name and its corresponding setter method.
     * If a setter method is not found, the attribute value is set directly on the object.
     *
     * @param string $attributeName The name of the attribute.
     * @param mixed  $value         The value to set.
     *
     * @throws AttributeAccessException if the attribute is not found.
     */
    public function setAttribute($attributeName, $value) {
        $setterMethod = 'set' . ucfirst($attributeName);
        if (method_exists($this, $setterMethod)) {
            call_user_func([$this, $setterMethod], $value); // set value by setter
        } else {
            $this->$attributeName = $value; //  set directly on the object.";
            if (property_exists($this, $attributeName)) {
                $this->$attributeName = $value; // Set value directly on the object property
            } else {
                throw new AttributeAccessException($attributeName, "Attribute '$attributeName' does not exist or is not accessible.");
            }
        }
    }

    /**
     * Get the value of an object's attribute using the attribute name and its corresponding getter method.
     * If a getter method is not found, the attribute value is retrieved directly from the object.
     *
     * @param string $attributeName The name of the attribute.
     *
     * @return mixed The value of the attribute.
     *
     * @throws AttributeAccessException if the attribute is not accessible.
     */
    public function getAttribute($attributeName) {
        $getterMethod = 'get' . ucfirst($attributeName);

        if (method_exists($this, $getterMethod)) {
            return call_user_func([$this, $getterMethod]);
        } elseif (property_exists($this, $attributeName)) {
            return $this->$attributeName;
        } else {
            throw new AttributeAccessException($attributeName, "Attribute '$attributeName' does not exist or is not accessible.");
        }
    }
}