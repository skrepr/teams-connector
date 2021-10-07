<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Actions\ActionCard;
use Skrepr\TeamsConnector\Actions\HttpPostAction;
use Skrepr\TeamsConnector\Card;
use Skrepr\TeamsConnector\CardInterface;
use Skrepr\TeamsConnector\Inputs\DateInput;
use Skrepr\TeamsConnector\Inputs\MultiChoiceInput;
use Skrepr\TeamsConnector\Inputs\TextInput;
use Skrepr\TeamsConnector\Section\Section;

final class ClientFunctionalTest extends TestCase
{
    public function testSimpleCard(): void
    {
        $card = new Card('Text');

        $expectedHttpData = [
            '@type' => 'MessageCard',
            'title' => 'Text',
            'themeColor' => CardInterface::STATUS_DEFAULT,
            'text' => null,
            'sections' => [],
            'potentialAction' => [],
        ];

        $this->assertSame($expectedHttpData, $card->toArray());
    }

    public function testSimpleCardWithSection(): void
    {
        $section = (new Section('Section'))
            ->setActivityText('Dummy text')
            ->setActivitySubtitle('Subtitle')
            ->setActivityImage('https://teamsnodesample.azurewebsites.net/static/img/image5.png')
            ->addFact('Fact 1', 'Value 1')
            ->addFact('Fact 2', 'Value 2');

        $card = (new Card(''))
            ->setTitle('Title')
            ->setText('Text')
            ->setThemeColor(CardInterface::STATUS_FAILURE)
            ->addSection($section);

        $sectionsOutput = [
            'activityTitle' => 'Section',
            'activitySubtitle' => 'Subtitle',
            'activityText' => 'Dummy text',
            'activityImage' => 'https://teamsnodesample.azurewebsites.net/static/img/image5.png',
            'markdown' => true,
            'facts' => [
                [
                    'name' => 'Fact 1',
                    'value' => 'Value 1',
                ],
                [
                    'name' => 'Fact 2',
                    'value' => 'Value 2',
                ],
            ],
        ];

        $expectedHttpData = [
            '@type' => 'MessageCard',
            'title' => 'Title',
            'themeColor' => CardInterface::STATUS_FAILURE,
            'text' => 'Text',
            'sections' => [$sectionsOutput],
            'potentialAction' => [],
        ];

        $this->assertSame($expectedHttpData, $card->toArray());
    }

    public function testCardWithSectionAndActions(): void
    {
        $actionCard = (new ActionCard('Add a comment'))
            ->addInput(new TextInput('comment', 'Add a comment here for this task'))
            ->addInput(new DateInput('dueDate', 'Enter a due date for this task'))
            ->addInput((new MultiChoiceInput('list', 'Select a status', true))->addChoice('In Progress', '2'))
            ->addAction(new HttpPostAction('Add comment', 'http://...'));

        $section = (new Section('Larry Bryant created a new task'))
            ->setActivitySubtitle('On Project Tango')
            ->setActivityText('Dummy text')
            ->setActivityImage('https://teamsnodesample.azurewebsites.net/static/img/image5.png')
            ->addFact('Assigned to', 'Unassigned')
            ->addFact('Due date', 'Mon May 01 2017 17:07:18 GMT-0700 (Pacific Daylight Time)')
            ->setMarkDown(false);

        $card = (new Card('Larry Bryant created a new task'))
            ->setText('Yes, he did')
            ->setThemeColor(CardInterface::STATUS_DEFAULT)
            ->setTitle('Adding Title to the card')
            ->addSection($section)
            ->addPotentialAction($actionCard);

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

        $sectionsOutput = [
            'activityTitle' => 'Larry Bryant created a new task',
            'activitySubtitle' => 'On Project Tango',
            'activityText' => 'Dummy text',
            'activityImage' => 'https://teamsnodesample.azurewebsites.net/static/img/image5.png',
            'markdown' => false,
            'facts' => [
                [
                    'name' => 'Assigned to',
                    'value' => 'Unassigned',
                ],
                [
                    'name' => 'Due date',
                    'value' => 'Mon May 01 2017 17:07:18 GMT-0700 (Pacific Daylight Time)',
                ],
            ],
        ];

        $expectedHttpData = [
            '@type' => 'MessageCard',
            'title' => 'Adding Title to the card',
            'themeColor' => CardInterface::STATUS_DEFAULT,
            'text' => 'Yes, he did',
            'sections' => [$sectionsOutput],
            'potentialAction' => [$actionOutput],
        ];

        $this->assertSame($expectedHttpData, $card->toArray());
    }
}
