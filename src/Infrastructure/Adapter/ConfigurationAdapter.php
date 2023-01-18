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

    public function automaticAddFooter(): bool
    {
        return (bool) $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::AUTOMATIC_ADD_FOOTER));
    }

    public function getSenderAddress(): string
    {
        return (string) $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::SENDER_ADDRESS));
    }

    public function getSenderName(): string
    {
        return (string) $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::SENDER_NAME));
    }

    public function getBccAddress(): ?string
    {
        $configuration = $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::BCC_ADDRESS));
        return $configuration !== null ? (string) $configuration : null;
    }

    public function getReturnPathName(): ?string
    {
        $configuration = $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::RETURN_PATH_ADDRESS));
        return $configuration !== null ? (string) $configuration : null;
    }

    public function getTransformationType(): ?string
    {
        $configuration = $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::TRANSFORMATION_TYPE));
        return $configuration !== null ? (string) $configuration : null;
    }

    public function getSubjectPrefix(): ?string
    {
        $configuration = $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::SUBJECT_PREFIX));
        return $configuration !== null ? (string) $configuration : null;
    }
}
