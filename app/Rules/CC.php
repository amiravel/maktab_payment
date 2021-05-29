<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CC implements Rule
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
     * https://github.com/majidalavizadeh/ir-validator/blob/master/src/IrValidation.php#L130
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $cardNumber)
    {
        if (empty($cardNumber) || strlen($cardNumber) !== 16) {
            return false;
        }
        $cardToArr = str_split($cardNumber);
        $cardTotal = 0;
        for ($i = 0; $i < 16; $i++) {
            $c = (int)$cardToArr[$i];
            if ($i % 2 === 0) {
                $cardTotal += (($c * 2 > 9) ? ($c * 2) - 9 : ($c * 2));
            } else {
                $cardTotal += $c;
            }
        }
        return ($cardTotal % 10 === 0);
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
