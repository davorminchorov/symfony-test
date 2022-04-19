<?php

namespace App\DataTransferObjects;

use App\Factories\StoreEmailAddressRequestFactory;
use Symfony\Component\HttpFoundation\Request;

class StoreEmailAddressRequestDataTransferObject
{
    public function __construct(private string $emailAddress)
    {
    }

    /**
     * Creates a new data transfer object from the request instance.
     *
     * @param  Request  $request
     * 
     * @return StoreEmailAddressRequestDataTransferObject
     */
    public static function fromRequest(Request $request): StoreEmailAddressRequestDataTransferObject
    {
        return StoreEmailAddressRequestFactory::make(attributes: [
            'emailAddress' => $request->get('emailAddress'),
        ]);
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }
}
