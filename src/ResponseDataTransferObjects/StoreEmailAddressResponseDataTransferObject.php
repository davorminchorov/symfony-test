<?php

namespace App\ResponseDataTransferObjects;

use App\ResponseFactories\StoreEmailAddressResponseFactory;

class StoreEmailAddressResponseDataTransferObject
{
    public function __construct(private ?string $message = null, private ?string $statusCode = null)
    {
    }

    public static function prepare(string $message, string $statusCode): StoreEmailAddressResponseDataTransferObject
    {
        return StoreEmailAddressResponseFactory::make(attributes: [
            'message' => $message,
            'statusCode' => $statusCode,
        ]);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }
}
