<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use RichId\MailerBundle\Infrastructure\Repository\EmailFooterRepository;

#[ORM\Entity(repositoryClass: EmailFooterRepository::class)]
#[ORM\Table(name: 'module_email_footer')]
class EmailFooter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'slug', type: 'string', length: 255, unique: true)]
    private string $slug;

    #[ORM\Column(name: 'name', type: 'string', length: 255, unique: true)]
    private string $name;

    #[ORM\Column(name: 'position', type: 'integer', unique: true)]
    private int $position = 0;

    #[ORM\Column(name: 'default_value', type: 'string', length: 600)]
    private string $defaultValue;

    #[ORM\Column(name: 'value', type: 'string', length: 600, nullable: true)]
    private ?string $value;

    #[ORM\Column(name: 'date_update', type: 'datetime')]
    private \DateTime $dateUpdate;

    #[ORM\Column(name: 'description', type: 'string', nullable: true)]
    private ?string $description;

    #[ORM\Column(name: 'placeholder', type: 'string', length: 600, nullable: true)]
    private ?string $placeholder;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getDateUpdate(): \DateTime
    {
        return $this->dateUpdate;
    }

    public function getValueToUse(): string
    {
        if ($this->value !== null && $this->value !== '') {
            return $this->value;
        }

        return $this->defaultValue;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }
}
