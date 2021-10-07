<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Inputs;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class TextInput implements InputInterface
{
    private string $id;

    private string $title;

    private bool $multiline;

    public function __construct(string $id, string $title, bool $isMultiline = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->multiline = $isMultiline;
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

    public function isMultiline(): bool
    {
        return $this->multiline;
    }

    public function setMultiline(bool $multiline): self
    {
        $this->multiline = $multiline;

        return $this;
    }

    public function toArray(): array
    {
        return [
            '@type' => InputInterface::TEXT_INPUT,
            'id' => $this->getId(),
            'isMultiline' => $this->isMultiline(),
            'title' => $this->getTitle(),
        ];
    }
}
