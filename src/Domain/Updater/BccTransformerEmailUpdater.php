<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Updater;

use RichId\MailerBundle\Domain\Header\OriginalToListHeader;
use RichId\MailerBundle\Domain\Port\ConfigurationInterface;
use RichId\MailerBundle\Domain\Port\TemplatingInterface;
use RichId\MailerBundle\Infrastructure\DependencyInjection\Configuration;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class BccTransformerEmailUpdater
{
    #[Required]
    public ConfigurationInterface $configuration;

    #[Required]
    public TemplatingInterface $templating;

    public function __invoke(Email $email): void
    {
        if ($this->configuration->getTransformationType() !== Configuration::TRANSFORMATION_TYPE_BCC) {
            return;
        }

        $bccAddress = $this->configuration->getBccAddress();

        if ($bccAddress === null || $bccAddress === '') {
            throw new \LogicException('Option bcc_address is required on bcc transformation mode.');
        }

        $toList = \array_map(static fn ($address) => $address->getAddress(), $email->getTo());
        $ccList = \array_map(static fn ($address) => $address->getAddress(), $email->getCc());
        $bccList = $this->getBccList($email, $bccAddress);

        $head = $this->templating->render(
            '@RichIdMailer/bcc_tranformation.html.twig',
            [
                'toList'  => $toList,
                'ccList'  => $ccList,
                'bccList' => $bccList,
            ]
        );

        $email->html($head . ($email->getHtmlBody() ?? ''));
        $email->getHeaders()->add(new OriginalToListHeader($toList));

        $email->to($bccAddress);
        $email->cc();
        $email->bcc();
    }

    /** @return string[] */
    private function getBccList(Email $email, string $bccAddress): array
    {
        return \array_filter(\array_map(static fn ($address) => $address->getAddress(), $email->getBcc()), static fn ($address) => $address !== $bccAddress);
    }
}
