<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\EmailFooter;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;
use Symfony\Contracts\Service\Attribute\Required;

final class EmailFooterManager
{
    /** @var EmailFooterInterface[] */
    public array $footers;

    #[Required]
    public ConfigurationInterface $configuration;

    public function getFooter(?SymfonyEmail $email = null): ?string
    {
        if (empty($this->footers)) {
            return null;
        }

        $footerContent = '';

        foreach ($this->footers as $footer) {
            if ($footer instanceof DefaultEmailFooter && !$this->configuration->automaticAddFooter()) {
                continue;
            }

            $footerContent .= $footer->getFooter($email);
        }

        return \htmlspecialchars_decode(
            \trim(
                $footerContent
            )
        );
    }
}
