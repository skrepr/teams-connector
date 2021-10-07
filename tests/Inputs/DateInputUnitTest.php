<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests\Inputs;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Inputs\DateInput;
use Skrepr\TeamsConnector\Inputs\InputInterface;

final class DateInputUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $input = $this->getInput();

        $this->assertSame('dueDate', $input->getId());
        $this->assertSame('Enter a due date for this task', $input->getTitle());
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

    public function testToArray(): void
    {
        $input = $this->getInput();

        $output = [
            '@type' => InputInterface::DATE_INPUT,
            'id' => 'dueDate',
            'title' => 'Enter a due date for this task',
        ];

        $this->assertSame($output, $input->toArray());
    }

    public function getInput(): DateInput
    {
        return new DateInput('dueDate', 'Enter a due date for this task');
    }
}
