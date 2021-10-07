<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests\Inputs;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Inputs\InputInterface;
use Skrepr\TeamsConnector\Inputs\TextInput;

final class TextInputUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $input = $this->getInput();

        $this->assertSame('comment', $input->getId());
        $this->assertSame('Add a comment here for this task', $input->getTitle());
        $this->assertTrue($input->isMultiline());
    }

    public function testSetId(): void
    {
        $input = $this->getInput();

        $input->setId('newId');

        $this->assertSame('newId', $input->getId());
    }

    public function testSetTitle(): void
    {
        $input = $this->getInput();

        $input->setTitle('title');

        $this->assertSame('title', $input->getTitle());
    }

    public function testSetMultiLine(): void
    {
        $input = $this->getInput();

        $input->setMultiline(true);
        $this->assertTrue($input->isMultiline());

        $input->setMultiline(false);
        $this->assertFalse($input->isMultiline());
    }

    public function testToArray(): void
    {
        $input = $this->getInput();

        $output = [
            '@type' => InputInterface::TEXT_INPUT,
            'id' => 'comment',
            'isMultiline' => true,
            'title' => 'Add a comment here for this task',
        ];

        $this->assertSame($output, $input->toArray());
    }

    public function getInput(): TextInput
    {
        return new TextInput('comment', 'Add a comment here for this task', true);
    }
}
