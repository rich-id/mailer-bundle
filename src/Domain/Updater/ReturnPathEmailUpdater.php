<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class ReturnPathEmailUpdater
{
    #[Required]
    public ConfigurationInterface $configuration;

    public function __invoke(Email $email): void
    {
        $returnPathAddress = $this->configuration->getReturnPathName();

        if ($returnPathAddress === null || $returnPathAddress === '') {
            return;
        }

        $email->returnPath($returnPathAddress);
    }
}
