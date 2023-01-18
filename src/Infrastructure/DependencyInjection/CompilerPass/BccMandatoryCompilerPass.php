<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\MailerBundle\Infrastructure\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class BccMandatoryCompilerPass extends AbstractCompilerPass
{
    public const TYPE = PassConfig::TYPE_BEFORE_REMOVING;

    public function process(ContainerBuilder $container): void
    {
        $type = $container->getParameter(\sprintf('%s.%s', Configuration::CONFIG_NODE, Configuration::TRANSFORMATION_TYPE));

        if ($type !== Configuration::TRANSFORMATION_TYPE_BCC) {
            return;
        }

        $bccAddress = $container->getParameter(\sprintf('%s.%s', Configuration::CONFIG_NODE, Configuration::BCC_ADDRESS));

        if ($bccAddress === null || $bccAddress === '') {
            throw new \InvalidArgumentException('Option bcc_address is required on bcc transformation mode.');
        }
    }
}
