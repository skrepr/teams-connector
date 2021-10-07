<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Actions\HttpPostAction;
use Skrepr\TeamsConnector\Card;
use Skrepr\TeamsConnector\CardInterface;
use Skrepr\TeamsConnector\Exception\InvalidArgumentException;
use Skrepr\TeamsConnector\Section\Section;

final class CardUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $card = $this->getCard();

        $this->assertSame('Title', $card->getTitle());

        $this->assertNull($card->getText());
    }

    public function testSetText(): void
    {
        $card = $this->getCard();

        $card->setText('new Text');

        $this->assertSame('new Text', $card->getText());
    }

    public function testSetTitle(): void
    {
        $card = $this->getCard();

        $card->setTitle('new Title');

        $this->assertSame('new Title', $card->getTitle());
    }

    public function testSetThemeColor(): void
    {
        $card = $this->getCard();

        $card->setThemeColor(CardInterface::STATUS_SUCCESS);

        $this->assertSame(CardInterface::STATUS_SUCCESS, $card->getThemeColor());
    }

    public function testValidateThemeColor(): void
    {
        $card = $this->getCard();

        $this->expectException(InvalidArgumentException::class);
        $card->setThemeColor('invalid');
    }

    public function testAddSection(): void
    {
        $card = $this->getCard();

        $section = new Section('Test');

        $card->addSection($section);

        $this->assertSame($section, $card->getSections()[0]);
    }

    public function testAddingPotentialAction(): void
    {
        $card = $this->getCard();

        $action = new HttpPostAction('Test', 'https://...');

        $card->addPotentialAction($action);

        $this->assertSame($action, $card->getPotentialActions()[0]);
    }

    public function testToArray(): void
    {
        $card = (new Card('Larry Bryant created a new task'))
            ->setText('Yes, he did')
            ->setThemeColor(CardInterface::STATUS_DEFAULT)
            ->setTitle('Adding Title to the card');

        $expectedData = [
            '@type' => 'MessageCard',
            'title' => 'Adding Title to the card',
            'themeColor' => CardInterface::STATUS_DEFAULT,
            'text' => 'Yes, he did',
            'sections' => [],
            'potentialAction' => [],
        ];

        $this->assertSame($expectedData, $card->toArray());
    }

    protected function getCard(): Card
    {
        return new Card('Title');
    }
}
