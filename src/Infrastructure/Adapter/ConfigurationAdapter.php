<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\Adapter;

use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use RichId\MailerBundle\Infrastructure\DependencyInjection\Configuration as BundleConfiguration;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ConfigurationAdapter implements ConfigurationInterface
{
    #[Required]
    public ParameterBagInterface $parameterBag;

    public function isYopmailEnabled(): bool
    {
        return (bool) $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::YOPMAIL_ENABLED));
    }

    public function getSubjectPrefix(): ?string
    {
        $configuration = $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::SUBJECT_PREFIX));
        return ($configuration !== null) ? (string) $configuration : null;
    }
}
