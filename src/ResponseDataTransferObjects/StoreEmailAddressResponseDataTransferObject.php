<?php

namespace App\ResponseDataTransferObjects;

use App\Factories\StoreEmailAddressRequestFactory;
use App\Factories\StoreEmailAddressResponseFactory;
use Symfony\Component\HttpFoundation\Request;

class StoreEmailAddressResponseDataTransferObject
{
    public function __construct(private string $message, private string $statusCode)
    {
    }

    public function prepare(string $message, string $statusCode): StoreEmailAddressResponseDataTransferObject
    {
        return StoreEmailAddressResponseFactory::make([
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
