<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\MailerBundle\Domain\EmailFooter\EmailFooterManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class EmailFooterCompilerPass extends AbstractCompilerPass
{
    public const TAG = 'email.footer';

    public function process(ContainerBuilder $container): void
    {
        $references = $this->getReferences($container);
        $definition = $container->getDefinition(EmailFooterManager::class);
        $definition->setProperty('footers', $references);
    }

    /** @return Reference[] */
    private function getReferences(ContainerBuilder $container): array
    {
        return self::getSortedReferencesByTag(
            $container,
            self::TAG,
            static function (Reference $reference): int {
                /** @var \RichId\MailerBundle\Domain\EmailFooter\EmailFooterInterface $class */
                $class = (string) $reference;

                return $class::getPriority();
            }
        );
    }
}
