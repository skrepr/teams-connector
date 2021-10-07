<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Actions;

use Skrepr\TeamsConnector\Inputs\InputInterface;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class ActionCard implements ActionInterface
{
    private string $name;

    /**
     * @var InputInterface[]
     */
    private array $inputs;

    /**
     * @var ActionInterface[]
     */
    private array $actions;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->inputs = [];
        $this->actions = [];
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

    /**
     * @return ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return InputInterface[]
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function addInput(InputInterface $input): self
    {
        $this->inputs[] = $input;

        return $this;
    }

    public function clearInputs(): self
    {
        $this->inputs = [];

        return $this;
    }

    public function addAction(ActionInterface $action): self
    {
        $this->actions[] = $action;

        return $this;
    }

    public function clearActions(): self
    {
        $this->actions = [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            '@type' => ActionInterface::ACTION_CARD,
            'name' => $this->getName(),
            'inputs' => array_map(static fn (InputInterface $input) => $input->toArray(), $this->getInputs()),
            'actions' => array_map(static fn (ActionInterface $action) => $action->toArray(), $this->getActions()),
        ];
    }
}
