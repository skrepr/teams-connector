<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Section;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class Section implements SectionInterface
{
    private string $activityTitle;

    private ?string $activitySubtitle;

    private ?string $activityText;

    private ?string $activityImage;

    private bool $markDown;

    /**
     * @var array<int, array<string, string>>
     */
    private array $facts;

    public function __construct(string $activityTitle)
    {
        $this->activityTitle = $activityTitle;
        $this->activityImage = null;
        $this->activitySubtitle = null;
        $this->activityText = null;
        $this->markDown = true;
        $this->facts = [];
    }

    public function getActivityTitle(): string
    {
        return $this->activityTitle;
    }

    public function setActivityTitle(string $activityTitle): self
    {
        $this->activityTitle = $activityTitle;

        return $this;
    }

    public function getActivityImage(): ?string
    {
        return $this->activityImage;
    }

    public function setActivityImage(?string $activityImage): self
    {
        $this->activityImage = $activityImage;

        return $this;
    }

    public function getActivitySubtitle(): string
    {
        return $this->activitySubtitle;
    }

    public function setActivitySubtitle(string $activitySubtitle): self
    {
        $this->activitySubtitle = $activitySubtitle;

        return $this;
    }

    public function getActivityText(): ?string
    {
        return $this->activityText;
    }

    public function setActivityText(?string $activityText): self
    {
        $this->activityText = $activityText;

        return $this;
    }

    public function isMarkdown(): bool
    {
        return $this->markDown;
    }

    public function setMarkDown(bool $markdown): self
    {
        $this->markDown = $markdown;

        return $this;
    }

    public function getFacts(): array
    {
        return $this->facts;
    }

    public function addFact(string $name, string $value): self
    {
        $this->facts[] = [
            'name' => $name,
            'value' => $value,
        ];

        return $this;
    }

    public function clearFacts(): self
    {
        $this->facts = [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'activityTitle' => $this->activityTitle,
            'activitySubtitle' => $this->activitySubtitle,
            'activityText' => $this->activityText,
            'activityImage' => $this->activityImage,
            'markdown' => $this->markDown,
            'facts' => $this->facts,
        ];
    }
}
