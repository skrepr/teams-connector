<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Actions;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class OpenUriAction implements ActionInterface
{
    private string $name;

    private string $target;

    public function __construct(string $name, string $target)
    {
        $this->name = $name;
        $this->target = $target;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function toArray(): array
    {
        return [
            '@type' => ActionInterface::OPEN_URI_ACTION,
            'name' => $this->name,
            'target' => $this->target,
        ];
    }
}
