<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\EmailFooter;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use Symfony\Contracts\Service\Attribute\Required;

final class EmailFooterManager
{
    /** @var EmailFooterInterface[] */
    public array $footers;

    #[Required]
    public ConfigurationInterface $configuration;

    public function getFooter(): ?string
    {
        if (empty($this->footers)) {
            return null;
        }

        $footerContent = '';

        foreach ($this->footers as $footer) {
            $footerContent .= $footer->getFooter();
        }

        return \htmlspecialchars_decode(
            \trim(
                $footerContent
            )
        );
    }
}
