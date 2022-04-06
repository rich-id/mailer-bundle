<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Tests\Resources\Fixtures;

use RichCongress\RecurrentFixturesTestBundle\DataFixture\AbstractFixture;
use RichId\MailerBundle\Domain\Entity\EmailFooter;

final class EmailFooterFixtures extends AbstractFixture
{
    protected function loadFixtures(): void
    {
        $this->createObject(
            EmailFooter::class,
            '1',
            [
                'slug'         => 'footer_1',
                'name'         => 'First footer',
                'position'     => 1,
                'defaultValue' => 'First footer line,',
                'dateUpdate'   => new \DateTime(),
            ]
        );

        $this->createObject(
            EmailFooter::class,
            '2',
            [
                'slug'         => 'footer_2',
                'name'         => 'Second footer',
                'position'     => 2,
                'defaultValue' => 'Second footer line,',
                'dateUpdate'   => new \DateTime(),
            ]
        );
    }
}
