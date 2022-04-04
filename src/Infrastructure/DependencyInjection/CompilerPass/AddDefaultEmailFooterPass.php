<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\MailerBundle\Infrastructure\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class AddDefaultEmailFooterPass extends AbstractCompilerPass
{
    public const TYPE = PassConfig::TYPE_BEFORE_OPTIMIZATION;
    public const PRIORITY = 500;

    public function process(ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../Resources/config'));

        $automaticAddFooter = $container->resolveEnvPlaceholders(
            $container->getParameter(Configuration::getKey(Configuration::AUTOMATIC_ADD_FOOTER)),
            true
        );

        if ($automaticAddFooter) {
            $loader->load('email-footer-services.xml');
        }
    }
}
