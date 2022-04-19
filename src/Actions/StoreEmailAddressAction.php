<?php

namespace App\Actions;

use App\DataTransferObjects\StoreEmailAddressRequestDataTransferObject;
use App\Repositories\RedisCacheRepository;
use App\ResponseDataTransferObjects\StoreEmailAddressResponseDataTransferObject;
use App\ValueObjects\EmailAddress;
use Symfony\Component\HttpFoundation\Response;

class StoreEmailAddressAction
{
    public function __construct(private readonly RedisCacheRepository $redisCacheRepository)
    {
    }

    /**
     * Execute the action.
     */
    public function execute(StoreEmailAddressRequestDataTransferObject $requestDataTransferObject): StoreEmailAddressResponseDataTransferObject
    {
        $emailAddress = new EmailAddress(emailAddress: $requestDataTransferObject->getEmailAddress());

        $errorResponseDataTransferObject = $this->checkIfEmailAddressExistsAlready(emailAddress: $emailAddress);

        $successfulResponseDataTransferObject = $this->storeEmailAddressAndDate(emailAddress: $emailAddress);

        return $errorResponseDataTransferObject ?? $successfulResponseDataTransferObject;
    }

    private function checkIfEmailAddressExistsAlready(EmailAddress $emailAddress): ?StoreEmailAddressResponseDataTransferObject
    {
        $existingEmailAddress = $this->redisCacheRepository->get(key: $emailAddress->getEmailAddressChecksum());

        if (!$existingEmailAddress) {
            return null;
        }

        $existingEmailAddressDate = $this->redisCacheRepository->get(key: $this->getEmailAddressChecksumDateCacheKey($emailAddress));

        return StoreEmailAddressResponseDataTransferObject::prepare(
            message: sprintf(format: 'Your request has been already submitted at %s', values: $existingEmailAddressDate),
            statusCode: Response::HTTP_BAD_REQUEST
        );
    }

    private function storeEmailAddressAndDate(EmailAddress $emailAddress): StoreEmailAddressResponseDataTransferObject
    {
        $this->redisCacheRepository->set(
            key: $this->getEmailAddressChecksumCacheKey($emailAddress),
            value: $emailAddress->getCanonicalEmailAddress()
        );

        $this->redisCacheRepository->set(
            key: $this->getEmailAddressChecksumDateCacheKey($emailAddress),
            value: $date = date('Y-m-d H:i:s'),
        );

        return StoreEmailAddressResponseDataTransferObject::prepare(
            message: sprintf(format: 'Your request has been added at %s', values: $date),
            statusCode: Response::HTTP_OK
        );
    }

    private function getEmailAddressChecksumDateCacheKey(EmailAddress $emailAddress): string
    {
        return "{$emailAddress->getEmailAddressChecksum()}_date";
    }

    private function getEmailAddressChecksumCacheKey(EmailAddress $emailAddress): string
    {
        return (string) $emailAddress->getEmailAddressChecksum();
    }
}
