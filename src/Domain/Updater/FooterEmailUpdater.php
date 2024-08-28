<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Email;
use RichId\MailerBundle\Domain\EmailFooter\EmailFooterManager;
use Symfony\Component\Mime\Email as SymfonyEmail;
use Symfony\Contracts\Service\Attribute\Required;

final class FooterEmailUpdater
{
    #[Required]
    public EmailFooterManager $emailFooterManager;

    public function __invoke(SymfonyEmail $email): void
    {
        $footer = $this->emailFooterManager->getFooter($email);
        $htmlBody = $email->getHtmlBody();

        $forceDisabled = $email instanceof Email && $email->isFooterDisabled();

        if ($forceDisabled || $footer === null || $footer === '' || $htmlBody === null || $htmlBody === '') {
            return;
        }

        if (mb_strpos((string) $htmlBody, $footer) !== false) {
            return;
        }

        $email->html($htmlBody . $footer);
    }
}
