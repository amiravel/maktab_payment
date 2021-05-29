<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IBAN implements Rule
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
     * https://github.com/majidalavizadeh/ir-validator/blob/master/src/IrValidation.php#L23
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new \PHP_IBAN\IBAN($value))->Verify();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute وارد شده معتبر نیست.';
    }
}
