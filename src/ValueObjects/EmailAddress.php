<?php

namespace App\ValueObjects;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmailAddress
{
    #[NotBlank(
        message: 'The email address is required.',
    )]
    #[Email(
        message: 'The email address {{ value }} is not a valid email address.',
    )]
    private readonly string $emailAddress;

    /**
     * @param string $emailAddress
     */
    public function __construct(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Generates a canonical version of the email address.
     * 
     * @return string
     */
    public function getCanonicalEmailAddress(): string
    {
        $emailAddress = explode('@', $this->emailAddress);

        $emailAddress[0] = strtolower($emailAddress[0]);
        $emailAddress[0] = preg_replace('#(\+[^@]*)#', '', $emailAddress[0]);

        return implode('@', $emailAddress);
    }

    /**
     * Gets the checksum of the email address.
     * 
     * @return int
     */
    public function getEmailAddressChecksum(): int
    {
        return crc32($this->getCanonicalEmailAddress());
    }
}
