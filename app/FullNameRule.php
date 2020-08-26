<?php


namespace App;


use Illuminate\Contracts\Validation\Rule;

class FullNameRule implements Rule
{

    public function passes($attribute, $value)
    {
        $parts = explode(' ', trim($value));
        if (count($parts) != 3) {
            return false;
        }
        for ($i = 0; $i < 3; $i++) {
            if (strlen($parts[$i]) == 0) {
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return 'Поле :attribute должно содержать три слова, разделенные одним пробелом';
    }
}
