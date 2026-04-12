<?php

namespace App\Enums\Enums;

enum BookingSource: string
{
    case Direct = 'direct';
    case Website = 'website';
    case TravelAgency = 'travel-agency';
}
