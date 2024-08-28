<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\MailerBundle\Domain\SubjectPrefix\SubjectPrefixInterface;
use RichId\MailerBundle\Domain\SubjectPrefix\SubjectPrefixManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SubjectPrefixCompilerPass extends AbstractCompilerPass
{
    public const TAG = 'email.subject_prefix';

    public function process(ContainerBuilder $container): void
    {
        $references = $this->getReferences($container);
        $definition = $container->getDefinition(SubjectPrefixManager::class);
        $definition->setProperty('prefixes', $references);
    }

    /** @return Reference[] */
    private function getReferences(ContainerBuilder $container): array
    {
        return self::getSortedReferencesByTag(
            $container,
            self::TAG,
            static function (Reference $reference): int {
                /** @var SubjectPrefixInterface $class */
                $class = (string) $reference;

                return $class::getPriority();
            }
        );
    }
}
