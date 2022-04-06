<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Port;

interface ConfigurationInterface
{
    public function automaticAddFooter(): bool;

    public function getSenderAddress(): string;
    public function getSenderName(): string;

    public function getBccAddress(): ?string;
    public function getReturnPathName(): ?string;

    public function isYopmailEnabled(): bool;
    public function getSubjectPrefix(): ?string;
}
