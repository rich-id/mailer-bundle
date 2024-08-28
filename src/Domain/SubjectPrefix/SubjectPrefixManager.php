<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\SubjectPrefix;

use Symfony\Component\Mime\Email as SymfonyEmail;

class SubjectPrefixManager
{
    /** @var SubjectPrefixInterface[] */
    public array $prefixes;

    public function getPrefix(SymfonyEmail $email): ?string
    {
        if (empty($this->prefixes)) {
            return null;
        }

        return \htmlspecialchars_decode(
            \trim(
                \implode(
                    ' ',
                    \array_map(
                        fn (SubjectPrefixInterface $service) => $service->getPrefix($email),
                        $this->prefixes
                    )
                )
            )
        );
    }
}
