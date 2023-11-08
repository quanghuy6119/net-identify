<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomValidationProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Disable lazy loading in development mode
        // Model::preventLazyLoading(! app()->isProduction());
        // validate key of array must be integer
        \Validator::extend('integer_keys', function ($attribute, $value, $parameters, $validator) {
            return is_array($value) && count(array_filter(array_keys($value), 'is_string')) === 0;
        });

        // validate not contain special char and number
        \Validator::extend('not_special_char_number', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[^!@#$%^&*()_+\-=\[\]{};`\':"\\|,.<>\/?0-9]*$/', $value);
        });

        // validate not contain special char 
        \Validator::extend('not_special_char', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[^!@#$%^&*()_+\-=\[\]{};`\':"\\|,.<>\/?]*$/', $value);
        });

        // validate not contain number
        \Validator::extend('not_number', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[^0-9]*$/', $value);
        });

        // validate not contain space
        \Validator::extend('not_space', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[^\s]*$/', $value);
        });

        // validate date format ISO 8601
        \Validator::extend('date_format_iso8601', function ($attribute, $value, $parameters, $validator) {
            if (is_string($value) && preg_match("/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(\.\d+)?Z$/", $value) && strtotime($value)) {
                return true;
            }
            return false;
        });

        // validate string or array of string
        \Validator::extend('string_or_array', function ($attribute, $value, $parameters, $validator) {
            // Check if value is string
            $isString = is_string($value);
            // Check if value is array of string
            $isArrayOfString = false;
            if (is_array($value)) {
                $isAllItemsString = true;
                foreach ($value as $item) {
                    if (!is_string($item)) {
                        $isAllItemsString = false;
                        break;
                    }
                }
                $isArrayOfString = $isAllItemsString;
            }
            return $isString || $isArrayOfString;
        });

        // validate required if with array
        \Validator::extendImplicit('required_if_with_array', function ($attribute, $value, $parameters, $validator) {
            // Parameter 1 is attributes
            $otherField = $parameters[0];
            // Get number params
            $params = count($parameters);
            // Parameter 2 is array value compare
            $stringValues = "";
            for($i = 1; $i <= $params-1; $i++) {
                $slash = $i == 1 ? "" : ",";
                $stringValues = $stringValues. $slash.$parameters[$i];
            };
            $values = json_decode($stringValues, true); 
            // Get data
            $attributes = $validator->getData();
            $attributeValue = $attributes[$otherField] ?? null;
            if ($attributeValue === null) return true;
            // Set other field and values message 
            $validator->addReplacer('required_if_with_array', function ($message, $attribute, $rule, $parameters) use ($otherField, $stringValues) {
                return str_replace(':other_field', $otherField, str_replace(':values', $stringValues, $message));
            });
            // Check value null
            $result = array_diff($values, $attributeValue);
            if (count($result) != count($values) && !$value) return false;
            return true; 
        });

        // validate required if with array
        \Validator::extendImplicit('required_if_with_bool', function ($attribute, $value, $parameters, $validator) {
            // Parameter 1 is attributes
            $otherField = $parameters[0];
            // Get data
            $attributes = $validator->getData();
            $attributeValue = $attributes[$otherField] ?? null;
            if ($attributeValue === null) return true;
            // Get values
            $valBoolCompare = !!$parameters[1];
            // Set other field and values message 
            $validator->addReplacer('required_if_with_bool', function ($message, $attribute, $rule, $parameters) use ($otherField, $valBoolCompare) {
                $stringValue = $valBoolCompare ? 'true' : 'false';
                return str_replace(':other_field', $otherField, str_replace(':values', $stringValue, $message));
            });
            // Check result
            $result = $attributeValue === $valBoolCompare;
            if ($result && !$value) return false;
            return true; 
        });

        // validate required null if
        \Validator::extend('null_if', function ($attribute, $value, $parameters, $validator) {
            // Parameter 1 is attributes
            $otherField = $parameters[0];
            // Get number params
            $params = count($parameters);
            // Parameter 2 is array value compare
            $stringValues = "";
            for($i = 1; $i <= $params-2; $i++) {
                $slash = $i == 1 ? "" : ",";
                $stringValues = $stringValues. $slash.$parameters[$i];
            };
            $values = json_decode($stringValues, true); 
            // Parameter 3 is not equal expression if null and equal expression is not null
            $isNotEqualExp = $parameters[$params-1] ?? 0;
            // Get data
            $attributes = $validator->getData();
            $attributeValue = $attributes[$otherField] ?? null;
            if ($attributeValue === null) return true;
            if (is_array($attributeValue) && !$attributeValue) return true;
            // Set other field and values message 
            $validator->addReplacer('null_if', function ($message, $attribute, $rule, $parameters) use ($otherField, $isNotEqualExp, $stringValues) {
                $customMessage = $isNotEqualExp ?  __('auth.not_in') : __('auth.in');
                return str_replace(':other_field', $otherField, str_replace(':values', $customMessage.' '.$stringValues, $message));
            });
            // Check value null
            if (is_array($attributeValue))
            {
                $diffValues = array_diff($values, $attributeValue);
                $result = count($diffValues) != count($values);
                $result = !!$isNotEqualExp ? !$result : $result;
                if ($result && $value !== null) return false;
                return true; 
            }
            else
            {
                $result = in_array($attributeValue, $values);
                $result = !!$isNotEqualExp ? !$result : $result;
                if ($result && $value !== null) return false;
                return true; 
            }
        });

        // validate required if in array
        \Validator::extendImplicit('required_if_in_array', function ($attribute, $value, $parameters, $validator) {
            // Parameter 1 is attributes
            $otherField = $parameters[0];
            // Get number params
            $params = count($parameters);
            // Parameter 2 is array value compare
            $stringValues = "";
            for($i = 1; $i <= $params-1; $i++) {
                $slash = $i == 1 ? "" : ",";
                $stringValues = $stringValues. $slash.$parameters[$i];
            };
            $values = json_decode($stringValues, true); 
            // Get data
            $attributes = $validator->getData();
            $attributeValue = $attributes[$otherField] ?? null;
            if ($attributeValue === null) return true;
            // Set other field and values message 
            $validator->addReplacer('required_if_in_array', function ($message, $attribute, $rule, $parameters) use ($otherField, $stringValues) {
                return str_replace(':other_field', $otherField, str_replace(':values', $stringValues, $message));
            });
            // Check value
            if (in_array($attributeValue, $values) && $value === null) return false;
            return true; 
        });

        // Validate unique objects in array
        \Validator::extend('distinct_objects', function ($attribute, $value, $parameters, $validator) {
            // Attributes specific
            $attributeSpecific = $parameters[0];
            // Set other field and values message 
            $validator->addReplacer('distinct_objects', function ($message, $attribute, $rule, $parameters) use($attributeSpecific) {
                return str_replace(':other_field', $attributeSpecific, $message);
            });
            // Check unique 
            $uniqueValues = [];
            foreach ($value as $item) {
                // Check attributes specific
                $propertyValue = $item[$parameters[0]] ?? null;
                if (!$propertyValue) return true;
                // Check is distinct
                if (in_array($propertyValue, $uniqueValues)) return false; 
                $uniqueValues[] = $propertyValue;
            }
            return true;
        });
    }
}
