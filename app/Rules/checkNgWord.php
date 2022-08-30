<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkNgWord implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ngWord)
    {
        $this->ngWord = $ngWord;
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
        $count = 0;
        for($i=0; $i<count($this->ngWord); $i++){
            if(strpos($value, $this->ngWord[$i]) !== false)
            {
                $count++;
            }
        }
        if($count === 0)
        {
            return true;
        }else
        {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '使用できない記号、言葉が含まれています';
    }
}
