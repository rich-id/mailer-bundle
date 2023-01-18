<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Port;

interface TemplatingInterface
{
    /** @param array<string, array<string>> $context */
    public function render(string $name, array $context = []): string;
}
