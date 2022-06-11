<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MatchValue implements Rule
{
    private $expected;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->expected = $param;
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
        return $value == $this->expected;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        
        return "The value of :attribute must be $this->expected";
    }
}
