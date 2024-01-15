<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Header;

use Symfony\Component\Mime\Header\UnstructuredHeader;

final class OriginalToListHeader extends UnstructuredHeader
{
    public const NAME = 'X-Metadata-Original-To-List';

    /** @var string[] */
    private array $toList;

    /** @param string[] $toList */
    public function __construct(array $toList)
    {
        $this->toList = $toList;

        parent::__construct(self::NAME, '');
    }

    /** @return string[] */
    public function getToList(): array
    {
        return $this->toList;
    }
}
