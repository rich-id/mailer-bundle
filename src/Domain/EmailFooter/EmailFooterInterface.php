<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\EmailFooter;

use Symfony\Component\Mime\Email as SymfonyEmail;

interface EmailFooterInterface
{
    public function getFooter(?SymfonyEmail $email = null): string;

    public static function getPriority(): int;
}
