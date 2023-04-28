<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain;

use Symfony\Component\Mime\Email as SymfonyEmail;

class Email extends SymfonyEmail
{
    protected bool $isFooterDisabled = false;

    public function isFooterDisabled(): bool
    {
        return $this->isFooterDisabled;
    }

    public function setIsFooterDisabled(bool $isFooterDisabled): self
    {
        $this->isFooterDisabled = $isFooterDisabled;

        return $this;
    }
}
