<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RichId\MailerBundle\Domain\Entity\EmailFooter;

/**
 * @extends ServiceEntityRepository<EmailFooter>
 *
 * @method EmailFooter findOneBySlug(string $slug)
 */
class EmailFooterRepository extends ServiceEntityRepository
{
    /** @codeCoverageIgnore */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailFooter::class);
    }
}
