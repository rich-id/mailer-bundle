<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure;

use RichCongress\BundleToolbox\Configuration\AbstractBundle;

class RichIdMailerBundle extends AbstractBundle
{
    /** @var array<string, string> */
    protected static $doctrineAttributeMapping = [
        'RichId\\MailerBundle\\Domain\\Entity' => __DIR__ . '/../Domain/Entity',
    ];
}
