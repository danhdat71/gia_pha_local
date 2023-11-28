<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PreventEmailRule implements Rule
{
    protected $allow = [
        'gmail.com',
        'outlook.com',
        'yahoo.com',
        'yopmail.com',
    ];

    public function passes($attribute, $value)
    {
        $domain = explode('@', $value)[1];
        return in_array($domain, $this->allow);
    }

    public function message()
    {
        return ':Attribute không tồn tại';
    }
}
