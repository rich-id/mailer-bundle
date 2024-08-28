<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Tests\Resources;

use RichId\MailerBundle\Domain\SubjectPrefix\SubjectPrefixInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class CustomSubjectPrefix implements SubjectPrefixInterface
{
    public function getPrefix(SymfonyEmail $email): string
    {
        return 'Custom prefix -';
    }

    public static function getPriority(): int
    {
        return 0;
    }
}
