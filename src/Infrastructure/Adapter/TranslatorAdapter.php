<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\Adapter;

use RichId\MailerBundle\Domain\Port\TranslatorInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

class TranslatorAdapter implements TranslatorInterface
{
    #[Required]
    public SymfonyTranslatorInterface $translator;

    /** @param array<string, string> $parameters */
    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
}
