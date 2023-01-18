<?php

declare(strict_types=1);

return [
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class                            => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class                    => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                                             => ['all' => true],
    RichCongress\RecurrentFixturesTestBundle\RichCongressRecurrentFixturesTestBundle::class => ['all' => true],
    RichId\MailerBundle\Infrastructure\RichIdMailerBundle::class                            => ['all' => true],
];
