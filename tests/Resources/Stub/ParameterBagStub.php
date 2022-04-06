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

    public function clear()
    {
        return $this->innerService->clear();
    }

    public function add(array $parameters)
    {
        return $this->innerService->add($parameters);
    }

    public function all()
    {
        return $this->innerService->all();
    }

    public function get(string $name)
    {
        if (isset($this->customParameters[$name])) {
            return $this->customParameters[$name];
        }

        return $this->innerService->get($name);
    }

    public function remove(string $name)
    {
        return $this->innerService->remove($name);
    }

    public function set(string $name, $value)
    {
        return $this->innerService->set($name, $value);
    }

    public function has(string $name)
    {
        return $this->innerService->has($name);
    }

    public function resolve()
    {
        return $this->innerService->resolve();
    }

    public function resolveValue($value)
    {
        return $this->innerService->resolveValue($value);
    }

    public function escapeValue($value)
    {
        return $this->innerService->escapeValue($value);
    }

    public function unescapeValue($value)
    {
        return $this->innerService->unescapeValue($value);
    }
}
