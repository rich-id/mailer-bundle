<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Tests\Resources\Stub;

use RichCongress\WebTestBundle\OverrideService\AbstractOverrideService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class ParameterBagStub extends AbstractOverrideService implements ParameterBagInterface
{
    /** @var string|array<string> */
    public static $overridenServices = ParameterBagInterface::class;

    /** @var ParameterBagInterface */
    protected $innerService;

    /** @var array<string, string|bool> */
    public array $customParameters = [];

    public function clear(): void
    {
        $this->innerService->clear();
    }

    public function add(array $parameters): void
    {
        $this->innerService->add($parameters);
    }

    public function all(): array
    {
        return $this->innerService->all();
    }

    public function get(string $name): array|bool|string|int|float|\UnitEnum|null
    {
        if (isset($this->customParameters[$name])) {
            return $this->customParameters[$name];
        }

        return $this->innerService->get($name);
    }

    public function remove(string $name): void
    {
        $this->innerService->remove($name);
    }

    public function set(string $name, array|bool|string|int|float|\UnitEnum|null $value): void
    {
        $this->innerService->set($name, $value);
    }

    public function has(string $name): bool
    {
        return $this->innerService->has($name);
    }

    public function resolve(): void
    {
        $this->innerService->resolve();
    }

    public function resolveValue(mixed $value): mixed
    {
        return $this->innerService->resolveValue($value);
    }

    public function escapeValue(mixed $value): mixed
    {
        return $this->innerService->escapeValue($value);
    }

    public function unescapeValue(mixed $value): mixed
    {
        return $this->innerService->unescapeValue($value);
    }
}
