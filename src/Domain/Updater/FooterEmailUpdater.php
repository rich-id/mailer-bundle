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

        $foundedFooter = \substr($htmlBody, -\strlen($footer));

        if ($foundedFooter !== false && $foundedFooter === $footer) {
            return;
        }

        $email->html($htmlBody . $footer);
    }
}
