<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\SubjectPrefix;

use Symfony\Component\Mime\Email as SymfonyEmail;

interface SubjectPrefixInterface
{
    public function getPrefix(SymfonyEmail $email): string;

    public static function getPriority(): int;
}
