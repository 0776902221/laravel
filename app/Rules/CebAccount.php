<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CebAccount implements Rule
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
        // CEB validator
        $acc = $value; // 2994135213

        if(strlen($acc) != 10){
            return false;
        }

        $number = str_split(substr($acc,0,9));
        $number = collect($number);

        $sum = $number->map(function($item,$key){
            return $item * (10 - $key);
        })->sum();

        $rm = $sum % 11;
        $cd = 11 - $rm;

        if($cd == 11){
            $cd = 0;
        }

        $last_digit = substr($acc,-1);

        return $last_digit == $cd;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid CEB account !.';
    }
}