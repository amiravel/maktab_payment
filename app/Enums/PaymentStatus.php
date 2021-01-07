<?php


namespace App\Enums;


use BenSampo\Enum\Enum;

final class PaymentStatus extends Enum
{
    const Waiting = 0;
    const Successful = 1;
    const Unsuccessful = -1;
}
