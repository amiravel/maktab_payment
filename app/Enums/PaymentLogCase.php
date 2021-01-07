<?php


namespace App\Enums;


use BenSampo\Enum\Enum;

final class PaymentLogCase extends Enum
{
    const Unsuccessful = -1;
    const Create = 0;
    const Successful = 1;
    const Other = 2;
}
