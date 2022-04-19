<?php

namespace App\ResponseFactories;

use App\ResponseDataTransferObjects\StoreEmailAddressResponseDataTransferObject;

class StoreEmailAddressResponseFactory
{
    public static function make(array $attributes): StoreEmailAddressResponseDataTransferObject
    {
        return new StoreEmailAddressResponseDataTransferObject(
            message: $attributes['message'],
            statusCode: $attributes['statusCode']
        );
    }
}
