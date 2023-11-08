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
trait ObjectAttributeTrait {

    /**
     * Set values.
     *
     * @param array $attributes An associative array where the keys represent attribute names and the values are the corresponding values.
     *
     * @throws AttributeAccessException if a setter method for any attribute does not exist.
     */
    public function setAttributes($object, array $attributes) {
        foreach ($attributes as $attributeName => $value) {
            $this->setAttribute($object, $attributeName, $value);
        }
    }

    /**
     * Get values.
     *
     * @param object a target object
     * @param array $attributeNames An array of attribute names to retrieve.
     *
     * @return array An associative array where the keys represent attribute names and the values are the corresponding attribute values.
     *
     * @throws AttributeAccessException if a getter method for any attribute does not exist.
     */
    public function getAttributes($object, array $attributeNames) {
        $result = [];

        foreach ($attributeNames as $attributeName) {
            $result[$attributeName] = $this->getAttribute($object, $attributeName);
        }

        return $result;
    }

    /**
     * Set the value to object by attribute by setter
     * If a setter method is not found, the attribute value is set directly on the object.
     *
     * @param object $object The target object.
     * @param string $attributeName The name of the attribute.
     * @param mixed  $value         The value to set.
     *
     * @throws AttributeAccessException if the attribute is not found.
     */
    public function setAttribute($object, $attributeName, $value) {
        $setterMethod = 'set' . ucfirst($attributeName);
        if (method_exists($object, $setterMethod)) {
            call_user_func([$object, $setterMethod], $value); // set value by setter
        } else {
            $object->$attributeName = $value; //  set directly on the object.";
            if (property_exists($object, $attributeName)) {
                $object->$attributeName = $value; // Set value directly on the object property
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
    public function getAttribute($object, $attributeName) {
        $getterMethod = 'get' . ucfirst($attributeName);

        if (method_exists($object, $getterMethod)) {
            return call_user_func([$object, $getterMethod]);
        } elseif (property_exists($object, $attributeName)) {
            return $object->$attributeName;
        } else {
            throw new AttributeAccessException($attributeName, "Attribute '$attributeName' does not exist or is not accessible.");
        }
    }
}