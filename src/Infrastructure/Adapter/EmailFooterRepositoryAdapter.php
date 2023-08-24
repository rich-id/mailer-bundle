<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\Adapter;

use RichId\MailerBundle\Domain\Entity\EmailFooter;
use RichId\MailerBundle\Domain\Port\EmailFooterRepositoryInterface;
use RichId\MailerBundle\Infrastructure\Repository\EmailFooterRepository;
use Symfony\Contracts\Service\Attribute\Required;

class EmailFooterRepositoryAdapter implements EmailFooterRepositoryInterface
{
    #[Required]
    public EmailFooterRepository $emailFooterRepository;

    public function getEmailFooters(): array
    {
        return $this->emailFooterRepository->findBy([], ['position' => 'ASC']);
    }

    public function findOneBySlug(string $slug): EmailFooter
    {
        return $this->emailFooterRepository->findOneBySlug($slug);
    }
}
