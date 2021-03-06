<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Tests;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\MailerBundle\Infrastructure\TestCase\MailerAssertionsTrait;
use RichId\MailerBundle\Tests\Resources\Stub\ParameterBagStub;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Exception\LogicException;
use Symfony\Component\Mime\Message;

/**
 * @covers \RichId\MailerBundle\Domain\EmailFooter\DefaultEmailFooter
 * @covers \RichId\MailerBundle\Domain\EmailFooter\EmailFooterManager
 * @covers \RichId\MailerBundle\Domain\Entity\EmailFooter
 * @covers \RichId\MailerBundle\Domain\Updater\BccEmailUpdater
 * @covers \RichId\MailerBundle\Domain\Updater\FooterEmailUpdater
 * @covers \RichId\MailerBundle\Domain\Updater\ReturnPathEmailUpdater
 * @covers \RichId\MailerBundle\Domain\Updater\SenderEmailUpdater
 * @covers \RichId\MailerBundle\Domain\Updater\SubjectPrefixEmailUpdater
 * @covers \RichId\MailerBundle\Domain\Updater\YopmailEmailUpdater
 *
 * @covers \RichId\MailerBundle\Infrastructure\Adapter\ConfigurationAdapter
 * @covers \RichId\MailerBundle\Infrastructure\Adapter\EmailFooterRepositoryAdapter
 * @covers \RichId\MailerBundle\Infrastructure\Adapter\TranslatorAdapter
 * @covers \RichId\MailerBundle\Infrastructure\EventSubscriber\MessageEventSubscriber
 */
#[TestConfig('fixtures')]
final class SendEmailTest extends TestCase
{
    use MailerAssertionsTrait;

    public MailerInterface $mailer;
    public ParameterBagStub $parameterBagStub;

    public function testSendEmailWithMessage(): void
    {
        self::expectException(LogicException::class);

        $message = new Message();
        $this->mailer->send($message);
    }

    public function testSendEmailMinimumConfiguration(): void
    {
        $this->parameterBagStub->customParameters = [
            'rich_id_mailer.automatic_add_footer' => false,
        ];

        $email = new Email();
        $email->to('test@test.test');
        $email->html('test');

        $this->mailer->send($email);

        $this->assertEmailCount(1, null, false);
        $email = $this->getMailerMessages(null, false)[0];

        self::assertEmailTo('test@test.test', $email);
        self::assertEmailFrom('sender@test.test', $email);
        self::assertEmailBody('test', $email);
        self::assertEmailSubject(null, $email);
        self::assertNull($email->getReturnPath());
        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getBcc());
        self::assertEmpty($email->getAttachments());
    }

    public function testSendEmailWithReturnPath(): void
    {
        $this->parameterBagStub->customParameters = [
            'rich_id_mailer.automatic_add_footer' => false,
            'rich_id_mailer.return_path_address'  => 'bounces@test.test',
        ];

        $email = new Email();
        $email->to('test@test.test');
        $email->html('test');

        $this->mailer->send($email);

        $this->assertEmailCount(1, null, false);
        $email = $this->getMailerMessages(null, false)[0];

        self::assertEmailTo('test@test.test', $email);
        self::assertEmailFrom('sender@test.test', $email);
        self::assertEmailBody('test', $email);
        self::assertEmailSubject(null, $email);
        self::assertSame('bounces@test.test', $email->getReturnPath()->getAddress());
        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getBcc());
        self::assertEmpty($email->getAttachments());
    }

    public function testSendEmailWithBcc(): void
    {
        $this->parameterBagStub->customParameters = [
            'rich_id_mailer.automatic_add_footer' => false,
            'rich_id_mailer.bcc_address'          => 'bcc@test.test',
        ];

        $email = new Email();
        $email->to('test@test.test');
        $email->html('test');

        $this->mailer->send($email);

        $this->assertEmailCount(1, null, false);
        $email = $this->getMailerMessages(null, false)[0];

        self::assertEmailTo('test@test.test', $email);
        self::assertEmailFrom('sender@test.test', $email);
        self::assertEmailBody('test', $email);
        self::assertEmailSubject(null, $email);
        self::assertEmailBcc('bcc@test.test', $email);
        self::assertNull($email->getReturnPath());
        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getAttachments());
    }

    public function testSendEmailWithYopmailEnabled(): void
    {
        $this->parameterBagStub->customParameters = [
            'rich_id_mailer.automatic_add_footer' => false,
            'rich_id_mailer.yopmail_enabled'      => true,
        ];

        $email = new Email();
        $email->to('test@test.test');
        $email->bcc('bcc@test.test');
        $email->html('test');

        $this->mailer->send($email);

        $this->assertEmailCount(1, null, false);
        $email = $this->getMailerMessages(null, false)[0];

        self::assertEmailTo('test_test_test@yopmail.com', $email);
        self::assertEmailFrom('sender@test.test', $email);
        self::assertEmailBody('test', $email);
        self::assertEmailSubject(null, $email);
        self::assertEmailBcc('bcc@test.test', $email);
        self::assertNull($email->getReturnPath());
        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getAttachments());
    }

    public function testSendEmailWithSubjectPrefix(): void
    {
        $this->parameterBagStub->customParameters = [
            'rich_id_mailer.automatic_add_footer' => false,
            'rich_id_mailer.subject_prefix'       => 'My prefix -',
        ];

        $email = new Email();
        $email->to('test@test.test');
        $email->subject('My subject');
        $email->html('test');

        $this->mailer->send($email);

        $this->assertEmailCount(1, null, false);
        $email = $this->getMailerMessages(null, false)[0];

        self::assertEmailTo('test@test.test', $email);
        self::assertEmailFrom('sender@test.test', $email);
        self::assertEmailBody('test', $email);
        self::assertEmailSubject('My prefix - My subject', $email);
        self::assertNull($email->getReturnPath());
        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getBcc());
        self::assertEmpty($email->getAttachments());
    }

    public function testSendEmailWithFooter(): void
    {
        $email = new Email();
        $email->to('test@test.test');
        $email->html('test');

        $this->mailer->send($email);

        $this->assertEmailCount(1, null, false);
        $email = $this->getMailerMessages(null, false)[0];

        self::assertEmailTo('test@test.test', $email);
        self::assertEmailFrom('sender@test.test', $email);
        self::assertEmailBody('test<br />First footer line,<br /><br />Second footer line,<br />', $email);
        self::assertEmailSubject(null, $email);
        self::assertNull($email->getReturnPath());
        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getBcc());
        self::assertEmpty($email->getAttachments());
    }
}
