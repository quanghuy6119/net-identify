<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ContainIn implements Rule
{
    private array $allowValues = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $array)
    {
        $this->allowValues = $array;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !\array_diff($this->allowValues, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
