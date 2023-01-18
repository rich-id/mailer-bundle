<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_mailer';
    public const TRANSFORMATION_TYPE_YOPMAIL = 'yopmail';
    public const TRANSFORMATION_TYPE_BCC = 'bcc';

    public const SENDER_ADDRESS = 'sender_address';
    public const SENDER_NAME = 'sender_name';

    public const BCC_ADDRESS = 'bcc_address';
    public const RETURN_PATH_ADDRESS = 'return_path_address';

    public const SUBJECT_PREFIX = 'subject_prefix';
    public const TRANSFORMATION_TYPE = 'transformation_type';

    public const AUTOMATIC_ADD_FOOTER = 'automatic_add_footer';

    protected function buildConfig(NodeBuilder $rootNode): void
    {
        $this->senderAddressNode($rootNode);
        $this->senderNameNode($rootNode);
        $this->bccAddressNode($rootNode);
        $this->returnPathNode($rootNode);
        $this->subjectNode($rootNode);
        $this->transformationTypeNode($rootNode);
        $this->automaticAddFooterNode($rootNode);
    }

    protected function senderAddressNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode(self::SENDER_ADDRESS)
            ->isRequired();
    }

    protected function senderNameNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode(self::SENDER_NAME)
            ->isRequired();
    }

    protected function bccAddressNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode(self::BCC_ADDRESS)
            ->defaultNull();
    }

    protected function returnPathNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode(self::RETURN_PATH_ADDRESS)
            ->defaultNull();
    }

    protected function subjectNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode(self::SUBJECT_PREFIX)
            ->defaultNull();
    }

    protected function transformationTypeNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->enumNode(self::TRANSFORMATION_TYPE)
            ->values([self::TRANSFORMATION_TYPE_YOPMAIL, self::TRANSFORMATION_TYPE_BCC])
            ->defaultNull();
    }

    protected function automaticAddFooterNode(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->booleanNode(self::AUTOMATIC_ADD_FOOTER)
            ->defaultFalse();
    }
}
