<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractExtension;
use RichId\MailerBundle\Domain\EmailFooter\EmailFooterInterface;
use RichId\MailerBundle\Domain\SubjectPrefix\SubjectPrefixInterface;
use RichId\MailerBundle\Infrastructure\DependencyInjection\CompilerPass\EmailFooterCompilerPass;
use RichId\MailerBundle\Infrastructure\DependencyInjection\CompilerPass\SubjectPrefixCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RichIdMailerExtension extends AbstractExtension implements PrependExtensionInterface
{
    /** @param array<string, mixed> $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->parseConfiguration(
            $container,
            new Configuration(),
            $configs
        );

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->registerForAutoconfiguration(EmailFooterInterface::class)->addTag(EmailFooterCompilerPass::TAG);
        $container->registerForAutoconfiguration(SubjectPrefixInterface::class)->addTag(SubjectPrefixCompilerPass::TAG);
    }
}
