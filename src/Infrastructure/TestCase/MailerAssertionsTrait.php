<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\TestCase;

use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mailer\Event\MessageEvents;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

trait MailerAssertionsTrait
{
    abstract protected function getContainer(): ContainerInterface;

    public static function assertEmailBody(string $expected, Email $email): void
    {
        static::assertSame(\rtrim($expected), \rtrim((string) $email->getHtmlBody()));
    }

    public static function assertEmailSubject(?string $expected, Email $email): void
    {
        static::assertSame($expected, $email->getSubject());
    }

    /** @param string|string[] $expected */
    public static function assertEmailTo(string|array $expected, Email $email): void
    {
        static::assertEquals((array) $expected, self::extractAddresses($email->getTo()));
    }

    /** @param string|string[] $expected */
    public static function assertEmailCc(string|array $expected, Email $email): void
    {
        static::assertEquals((array) $expected, self::extractAddresses($email->getCc()));
    }

    /** @param string|string[] $expected */
    public static function assertEmailBcc(string|array $expected, Email $email): void
    {
        static::assertEquals((array) $expected, self::extractAddresses($email->getBcc()));
    }

    /** @param string|string[] $expected */
    public static function assertEmailFrom(string|array $expected, Email $email): void
    {
        static::assertEquals((array) $expected, self::extractAddresses($email->getFrom()));
    }

    /** @phpstan-ignore-next-line */
    public function getMailerMessages(?string $transport = null, bool $isQueued = true): array
    {
        return \array_values(
            \array_map(
                static function (MessageEvent $event) {
                    return $event->getMessage();
                },
                \array_filter(
                    $this->getMessageMailerEvents()->getEvents($transport),
                    static function (MessageEvent $event) use ($isQueued) {
                        return $event->isQueued() === $isQueued;
                    }
                )
            )
        );
    }

    public function assertEmailCount(int $count, ?string $transport = null, bool $isQueued = true): void
    {
        $queueEmails = \array_filter(
            $this->getMessageMailerEvents()->getEvents($transport),
            static function (MessageEvent $event) use ($isQueued) {
                return $event->isQueued() === $isQueued;
            }
        );

        self::assertSame($count, \count($queueEmails));
    }

    /**
     * @param Address[] $addresses
     *
     * @return string[]
     */
    private static function extractAddresses(array $addresses): array
    {
        return \array_map(
            static function (Address $address) {
                return $address->getAddress();
            },
            $addresses
        );
    }

    private function getMessageMailerEvents(): MessageEvents
    {
        $container = $this->getContainer();

        if ($container->has('mailer.message_logger_listener')) {
            return $container->get('mailer.message_logger_listener')->getEvents();
        }

        if ($container->has('mailer.logger_message_listener')) {
            return $container->get('mailer.logger_message_listener')->getEvents();
        }

        throw new \LogicException('Did you forget to require symfony/mailer?');
    }
}
