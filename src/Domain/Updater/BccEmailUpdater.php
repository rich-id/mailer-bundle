<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class BccEmailUpdater
{
    #[Required]
    public ConfigurationInterface $configuration;

    public function __invoke(Email $email): void
    {
        $bccAddress = $this->configuration->getBccAddress();

        if ($bccAddress === null || $bccAddress === '') {
            return;
        }

        $email->addBcc($bccAddress);
    }
}
