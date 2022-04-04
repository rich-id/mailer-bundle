<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\EmailFooter;

interface EmailFooterInterface
{
    public function getFooter(): string;
    public static function getPriority(): int;
}
