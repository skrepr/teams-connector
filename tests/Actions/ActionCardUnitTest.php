<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Actions\ActionCard;
use Skrepr\TeamsConnector\Actions\HttpPostAction;
use Skrepr\TeamsConnector\Inputs\DateInput;
use Skrepr\TeamsConnector\Inputs\MultiChoiceInput;
use Skrepr\TeamsConnector\Inputs\TextInput;

final class ActionCardUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $action = $this->getAction();

        $this->assertSame('Add a comment', $action->getName());
    }

    public function testSetNameWithSetter(): void
    {
        $action = $this->getAction();

        $action->setName('Hello world');

        $this->assertSame('Hello world', $action->getName());
    }

    public function testAddAction(): void
    {
        $action = new HttpPostAction('HttpPostAction', 'https://...');

        $actionCard = $this->getAction();

        $actionCard->addAction($action);

        $this->assertSame($action, $actionCard->getActions()[0]);
    }

    public function testClearActions(): void
    {
        $action = new HttpPostAction('HttpPostAction', 'https://...');

        $actionCard = $this->getAction();

        $actionCard->addAction($action);

        $this->assertSame($action, $actionCard->getActions()[0]);

        $actionCard->clearActions();

        $this->assertSame([], $actionCard->getActions());
    }

    public function testAddInput(): void
    {
        $actionCard = $this->getAction();

        $input = new TextInput('Test input', 'Add title');

        $actionCard->addInput($input);

        $this->assertSame($input, $actionCard->getInputs()[0]);
    }

    public function testClearInputs(): void
    {
        $actionCard = $this->getAction();

        $input = new TextInput('Test input', 'Add title');

        $actionCard->addInput($input);

        $this->assertSame($input, $actionCard->getInputs()[0]);

        $actionCard->clearInputs();

        $this->assertSame([], $actionCard->getInputs());
    }

    public function testToArray(): void
    {
        $actionCard = $this->getAction()
            ->addInput(new TextInput('comment', 'Add a comment here for this task'))
            ->addInput(new DateInput('dueDate', 'Enter a due date for this task'))
            ->addInput((new MultiChoiceInput('list', 'Select a status', true))->addChoice('In Progress', '2'))
            ->addAction(new HttpPostAction('Add comment', 'http://...'));

        $actionOutput = [
            '@type' => 'ActionCard',
            'name' => 'Add a comment',
            'inputs' => [
                [
                    '@type' => 'TextInput',
                    'id' => 'comment',
                    'isMultiline' => false,
                    'title' => 'Add a comment here for this task',
                ],
                [
                    '@type' => 'DateInput',
                    'id' => 'dueDate',
                    'title' => 'Enter a due date for this task',
                ],
                [
                    '@type' => 'MultichoiceInput',
                    'id' => 'list',
                    'title' => 'Select a status',
                    'isMultiSelect' => true,
                    'choices' => [
                        [
                            'display' => 'In Progress',
                            'value' => '2',
                        ],
                    ],
                ],
            ],
            'actions' => [
                [
                    '@type' => 'HttpPOST',
                    'name' => 'Add comment',
                    'target' => 'http://...',
                ],
            ],
        ];

        $this->assertSame($actionCard->toArray(), $actionOutput);
    }

    protected function getAction(): ActionCard
    {
        return new ActionCard('Add a comment');
    }
}
