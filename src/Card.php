<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

use Skrepr\TeamsConnector\Actions\ActionInterface;
use Skrepr\TeamsConnector\Exception\InvalidArgumentException;
use Skrepr\TeamsConnector\Section\SectionInterface;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class Card implements CardInterface
{
    private string $themeColor;

    private string $title;

    private ?string $text;

    /**
     * @var SectionInterface[]
     */
    private array $sections;

    /**
     * @var ActionInterface[]
     */
    private array $potentialAction;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->text = null;
        $this->sections = [];
        $this->potentialAction = [];
        $this->setThemeColor(CardInterface::STATUS_DEFAULT);
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

    public function getThemeColor(): string
    {
        return $this->themeColor;
    }

    public function setThemeColor(string $themeColor): self
    {
        $this->validateThemeColor($themeColor);

        $this->themeColor = $themeColor;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return SectionInterface[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    public function addSection(SectionInterface $section): self
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * @return ActionInterface[]
     */
    public function getPotentialActions(): array
    {
        return $this->potentialAction;
    }

    public function addPotentialAction(ActionInterface $action): self
    {
        $this->potentialAction[] = $action;

        return $this;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'MessageCard',
            'title' => $this->title,
            'themeColor' => $this->themeColor,
            'text' => $this->text,
            'sections' => array_map(static fn (SectionInterface $section) => $section->toArray(), $this->sections),
            'potentialAction' => array_map(static fn (ActionInterface $action) => $action->toArray(), $this->potentialAction),
        ];
    }

    private function validateThemeColor(string $themeColor): void
    {
        if (!preg_match('/^#([0-9a-f]{6}|[0-9a-f]{3})$/i', $themeColor)) {
            throw new InvalidArgumentException('MessageCard themeColor must have a valid hex color format.');
        }
    }
}
