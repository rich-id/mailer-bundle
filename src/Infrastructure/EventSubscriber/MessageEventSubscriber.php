<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\EventSubscriber;

use RichId\MailerBundle\Domain\Updater\BccEmailUpdater;
use RichId\MailerBundle\Domain\Updater\FooterEmailUpdater;
use RichId\MailerBundle\Domain\Updater\ReturnPathEmailUpdater;
use RichId\MailerBundle\Domain\Updater\SenderEmailUpdater;
use RichId\MailerBundle\Domain\Updater\SubjectPrefixEmailUpdater;
use RichId\MailerBundle\Domain\Updater\YopmailEmailUpdater;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

class MessageEventSubscriber implements EventSubscriberInterface
{
    #[Required]
    public BccEmailUpdater $bccEmailUpdater;

    #[Required]
    public FooterEmailUpdater $footerEmailUpdater;

    #[Required]
    public ReturnPathEmailUpdater $returnPathEmailUpdater;

    #[Required]
    public SenderEmailUpdater $senderEmailUpdater;

    #[Required]
    public SubjectPrefixEmailUpdater $subjectPrefixEmailUpdater;

    #[Required]
    public YopmailEmailUpdater $yopmailEmailUpdater;

    public function onMessage(MessageEvent $event): void
    {
        $message = $event->getMessage();

        if (!$message instanceof Email) {
            return;
        }

        ($this->bccEmailUpdater)($message);
        ($this->footerEmailUpdater)($message);
        ($this->returnPathEmailUpdater)($message);
        ($this->senderEmailUpdater)($message);
        ($this->subjectPrefixEmailUpdater)($message);
        ($this->yopmailEmailUpdater)($message);
    }

    /** @codeCoverageIgnore */
    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::class => 'onMessage',
        ];
    }
}
