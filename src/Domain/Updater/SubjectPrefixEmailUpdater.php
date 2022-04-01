<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class SubjectPrefixEmailUpdater
{
    #[Required]
    public ConfigurationInterface $configuration;

    public function __invoke(Email $email): void
    {
        $subject = $email->getSubject() ?? '';
        $subjectPrefix = $this->configuration->getSubjectPrefix();

        if ($subjectPrefix === null || $subjectPrefix === '' || \str_starts_with($subject, $subjectPrefix)) {
            return;
        }

        $email->subject($subjectPrefix . ' ' . $subject);
    }
}
