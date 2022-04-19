<?php

namespace App\Factories;

use App\DataTransferObjects\StoreEmailAddressRequestDataTransferObject;

class StoreEmailAddressRequestFactory
{
    public static function make(array $attributes): StoreEmailAddressRequestDataTransferObject
    {
        return new StoreEmailAddressRequestDataTransferObject(
            emailAddress: $attributes['emailAddress'],
        );
    }
}
