<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Inputs;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class MultiChoiceInput implements InputInterface
{
    private string $id;

    private string $title;

    private bool $multiSelect;

    private array $choices;

    public function __construct(string $id, string $title, bool $isMultiSelect = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->multiSelect = $isMultiSelect;
        $this->choices = [];
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

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function isMultiSelect(): bool
    {
        return $this->multiSelect;
    }

    public function setMultiSelect(bool $multiSelect): self
    {
        $this->multiSelect = $multiSelect;

        return $this;
    }

    public function addChoice(string $display, string $value): self
    {
        $this->choices[] = [
            'display' => $display,
            'value' => $value,
        ];

        return $this;
    }

    public function clearChoices(): self
    {
        $this->choices = [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            '@type' => InputInterface::MULTI_CHOICE_INPUT,
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'isMultiSelect' => $this->isMultiSelect(),
            'choices' => $this->getChoices(),
        ];
    }
}
