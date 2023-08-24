<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Port;

use RichId\MailerBundle\Domain\Entity\EmailFooter;

interface EmailFooterRepositoryInterface
{
    /** @return EmailFooter[] */
    public function getEmailFooters(): array;

    public function findOneBySlug(string $slug): EmailFooter;
}
