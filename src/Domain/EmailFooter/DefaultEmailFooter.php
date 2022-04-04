<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\EmailFooter;

use RichId\MailerBundle\Domain\Entity\EmailFooter;
use RichId\MailerBundle\Domain\Port\EmailFooterRepositoryInterface;
use RichId\MailerBundle\Domain\Port\TranslatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

final class DefaultEmailFooter implements EmailFooterInterface
{
    #[Required]
    public EmailFooterRepositoryInterface $emailFooterRepository;

    #[Required]
    public TranslatorInterface $translator;

    public function getFooter(): string
    {
        $content = '';
        $footers = $this->emailFooterRepository->getEmailFooters();

        foreach ($footers as $footer) {
            $content .= $this->generteFooter($footer);
        }

        return $content;
    }

    private function generteFooter(EmailFooter $emailFooter): string
    {
        return \sprintf('<br />%s<br />', $this->translator->trans($emailFooter->getValueToUse()));
    }

    public static function getPriority(): int
    {
        return 0;
    }
}
