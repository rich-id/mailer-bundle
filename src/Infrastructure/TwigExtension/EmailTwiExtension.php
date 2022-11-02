<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\TwigExtension;

use RichId\MailerBundle\Domain\EmailFooter\EmailFooterManager;
use Symfony\Contracts\Service\Attribute\Required;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class EmailTwiExtension extends AbstractExtension
{
    #[Required]
    public EmailFooterManager $emailFooterManager;

    public function getFunctions()
    {
        return [
            new TwigFunction('getEmailHtmlFooter', [$this, 'getEmailHtmlFooter']),
        ];
    }

    public function getEmailHtmlFooter(): ?string
    {
        $footer = $this->emailFooterManager->getFooter();

        return $footer === '' ? null : $footer;
    }
}
