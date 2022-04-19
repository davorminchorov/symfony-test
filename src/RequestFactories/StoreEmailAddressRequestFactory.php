<?php

namespace App\RequestFactories;

use App\RequestDataTransferObjects\StoreEmailAddressRequestDataTransferObject;

class StoreEmailAddressRequestFactory
{
    public static function make(array $attributes): StoreEmailAddressRequestDataTransferObject
    {
        return new StoreEmailAddressRequestDataTransferObject(
            emailAddress: $attributes['emailAddress'],
        );
    }
}
