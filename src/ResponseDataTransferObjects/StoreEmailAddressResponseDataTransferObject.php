<?php

namespace App\ResponseDataTransferObjects;

use App\ResponseFactories\StoreEmailAddressResponseFactory;
use Symfony\Component\Serializer\Annotation\Ignore;

class StoreEmailAddressResponseDataTransferObject
{
    private readonly string $message;

    #[Ignore]
    private readonly int $statusCode;

    public function __construct(string $message, int $statusCode)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
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
