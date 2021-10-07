<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests\Inputs;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Inputs\InputInterface;
use Skrepr\TeamsConnector\Inputs\MultiChoiceInput;

final class MultiChoiceInputUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $input = $this->getInput();

        $this->assertSame('list', $input->getId());
        $this->assertSame('Select a status', $input->getTitle());
        $this->assertTrue($input->isMultiSelect());
    }

    public function testSetId(): void
    {
        $input = $this->getInput();

        $input->setId('newId');

        $this->assertSame('newId', $input->getId());
    }

    public function setTitle(): void
    {
        $input = $this->getInput();

        $input->setTitle('title');

        $this->assertSame('title', $input->getTitle());
    }

    public function testAddChoices(): void
    {
        $input = $this->getInput();

        $input->addChoice('In Progress', '2');
        $input->addChoice('Done', '3');

        $output = [
            [
                'display' => 'In Progress',
                'value' => '2',
            ],
            [
                'display' => 'Done',
                'value' => '3',
            ],
        ];

        $this->assertSame($output, $input->getChoices());
    }

    public function testSetMultiSelect(): void
    {
        $input = $this->getInput();

        $input->setMultiSelect(true);
        $this->assertTrue($input->isMultiSelect());

        $input->setMultiSelect(false);
        $this->assertFalse($input->isMultiSelect());
    }

    public function testClearChoices(): void
    {
        $input = $this->getInput();

        $input->addChoice('foo', 'bar');
        $this->assertGreaterThanOrEqual(1, count($input->getChoices()));

        $input->clearChoices();
        $this->assertSame([], $input->getChoices());
    }

    public function testToArray(): void
    {
        $input = $this->getInput();

        $output = [
            '@type' => InputInterface::MULTI_CHOICE_INPUT,
            'id' => 'list',
            'title' => 'Select a status',
            'isMultiSelect' => true,
            'choices' => [],
        ];

        $this->assertSame($output, $input->toArray());
    }

    protected function getInput(): MultiChoiceInput
    {
        return new MultiChoiceInput('list', 'Select a status', true);
    }
}
