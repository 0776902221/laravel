<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NIC implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //Old NIC
        if(strlen($value) < 12 && strlen($value) == 10){
            if(strtoupper(substr($value,-1)) == 'V' or strtoupper(substr($value,-1)) == 'X' or strtoupper(substr($value,-1)) == 'Z'){
                return true;
            }
        }

        //New NIC
        if(strlen($value) == 12 && is_numeric($value)){
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'NIC Format missed matched, New NIC required 12 digits ,Old one required 9 digits and letter x OR v';
    }
}