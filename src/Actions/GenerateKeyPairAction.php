<?php

namespace App\Actions;

use App\Exceptions\EmailDoesNotExistException;
use App\Repositories\RedisCacheRepository;
use App\ValueObjects\EmailAddress;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class GenerateKeyPairAction
{
    public function __construct(
        private readonly RedisCacheRepository $redisCacheRepository,
        private readonly MailerInterface $mailer
    ) {
    }

    /**
     * Execute the action.
     *
     * @throws TransportExceptionInterface
     * @throws EmailDoesNotExistException
     */
    public function execute(): void
    {
        $emailAddress = $this->redisCacheRepository->pop('emailAddresses');

        $this->validateEmailAddressExists($emailAddress);

        $emailAddressValueObject = new EmailAddress($emailAddress);

        $privateKey = $this->generatePrivateKey();
        $publicKey = $this->generatePublicKey($privateKey);

        $this->savePrivateKeyToFile($privateKey, $emailAddressValueObject->getEmailAddressChecksum());

        $this->redisCacheRepository->set(
            $this->getPublicKeyCacheKey($emailAddressValueObject->getEmailAddressChecksum()),
            $publicKey
        );

        $this->mailer->send(
            (new Email())
                ->from('hello@example.com')
                ->to($emailAddressValueObject->getCanonicalEmailAddress())
                ->subject('Here is your private key')
                ->text('Your private key is here for your eyes only. Save it securely somewhere where no one can get access to it.')
                ->attachFromPath($this->getPrivateKeyFilePath($emailAddressValueObject->getEmailAddressChecksum()))
            );
    }

    private function generatePrivateKey(): \OpenSSLAsymmetricKey|bool
    {
        return openssl_pkey_new();
    }

    private function generatePublicKey(\OpenSSLAsymmetricKey|bool $privateKey)
    {
        return $privateKey ? openssl_pkey_get_details($privateKey)['key'] : null;
    }

    private function getPrivateKeyFilePath(int $emailAddressChecksum): string
    {
        return "storage/{$emailAddressChecksum}.key";
    }

    private function savePrivateKeyToFile(\OpenSSLAsymmetricKey $privateKey, int $emailAddressChecksum): void
    {
        openssl_pkey_export_to_file($privateKey, $this->getPrivateKeyFilePath($emailAddressChecksum));
    }

    /**
     * @throws EmailDoesNotExistException
     */
    private function validateEmailAddressExists(?string $emailAddress): void
    {
        if (!$emailAddress) {
            throw new EmailDoesNotExistException('There is no email address in the email addresses list.');
        }
    }

    private function getPublicKeyCacheKey(int $emailAddressChecksum): string
    {
        return "publicKeys_{$emailAddressChecksum}";
    }
}
