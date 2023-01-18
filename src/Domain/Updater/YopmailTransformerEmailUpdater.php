<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use RichId\MailerBundle\Infrastructure\DependencyInjection\Configuration;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class YopmailTransformerEmailUpdater
{
    public const EXTENSION_YOPMAIL = '@yopmail.com';

    #[Required]
    public ConfigurationInterface $configuration;

    public function __invoke(Email $email): void
    {
        if ($this->configuration->getTransformationType() !== Configuration::TRANSFORMATION_TYPE_YOPMAIL) {
            return;
        }

        $this->applyYopmailOn('To', $email);
        $this->applyYopmailOn('Cc', $email);
    }

    private function applyYopmailOn(string $type, Email $email): void
    {
        $getter = 'get' . $type;
        $addresses = $email->$getter();

        if (!is_array($addresses)) {
            return;
        }

        $finalAddresses = [];

        /** @var Address $address */
        foreach ($addresses as $address) {
            if (\str_ends_with($address->getAddress(), self::EXTENSION_YOPMAIL)) {
                continue;
            }

            $newRecipient = str_replace(['.', '@'], '_', $address->getAddress());
            $newRecipient = substr($newRecipient, 0, 25);
            $newRecipient .= self::EXTENSION_YOPMAIL;

            $finalAddresses[] = new Address($newRecipient, $address->getName());
        }

        $setter = \strtolower($type);
        $email->$setter(...$finalAddresses);
    }
}
