<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\EmailFooter\EmailFooterManager;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class FooterEmailUpdater
{
    #[Required]
    public EmailFooterManager $emailFooterManager;

    public function __invoke(Email $email): void
    {
        $footer = $this->emailFooterManager->getFooter();
        $htmlBody = $email->getHtmlBody();

        if ($footer === null || $footer === '' || $htmlBody === null || $htmlBody === '') {
            return;
        }

        if (mb_strpos((string) $htmlBody, $footer) !== false) {
            return;
        }

        $email->html($htmlBody . $footer);
    }
}
