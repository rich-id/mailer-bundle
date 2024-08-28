<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use RichId\MailerBundle\Domain\SubjectPrefix\SubjectPrefixManager;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class SubjectPrefixEmailUpdater
{
    #[Required]
    public ConfigurationInterface $configuration;

    #[Required]
    public SubjectPrefixManager $subjectPrefixManager;

    public function __invoke(Email $email): void
    {
        $subject = $email->getSubject() ?? '';

        $subjectPrefix = \implode(
            ' ',
            \array_filter(
                [
                    $this->configuration->getSubjectPrefix(),
                    $this->subjectPrefixManager->getPrefix($email)
                ]
            )
        );

        if ($subjectPrefix === '' || \str_starts_with($subject, $subjectPrefix)) {
            return;
        }

        $email->subject($subjectPrefix . ' ' . $subject);
    }
}
