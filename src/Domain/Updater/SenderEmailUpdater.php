<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class SenderEmailUpdater
{
    #[Required]
    public ConfigurationInterface $configuration;

    public function __invoke(Email $email): void
    {
        $email->from(
            new Address(
                $this->configuration->getSenderAddress(),
                $this->configuration->getSenderName()
            )
        );
    }
}
