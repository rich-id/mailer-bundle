<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Port;

interface ConfigurationInterface
{
    public function isYopmailEnabled(): bool;
    public function getSubjectPrefix(): ?string;
}
