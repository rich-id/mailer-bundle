<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain;

use Symfony\Component\Mime\Email as SymfonyEmail;

class Email extends SymfonyEmail
{
    protected bool $isFooterDisabled = false;
    protected bool $isSubjectDisabled = false;

    public function isFooterDisabled(): bool
    {
        return $this->isFooterDisabled;
    }

    public function setIsFooterDisabled(bool $isFooterDisabled): self
    {
        $this->isFooterDisabled = $isFooterDisabled;

        return $this;
    }

    public function isSubjectDisabled(): bool
    {
        return $this->isSubjectDisabled;
    }

    public function setIsSubjectDisabled(bool $isSubjectDisabled): self
    {
        $this->isSubjectDisabled = $isSubjectDisabled;

        return $this;
    }
}
