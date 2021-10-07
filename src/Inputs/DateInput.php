<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Inputs;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class DateInput implements InputInterface
{
    private string $id;

    private string $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function toArray(): array
    {
        return [
            '@type' => InputInterface::DATE_INPUT,
            'id' => $this->getId(),
            'title' => $this->getTitle(),
        ];
    }
}
