<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Section\Section;

final class SectionUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $section = $this->getSection();

        $this->assertSame('Section title', $section->getActivityTitle());
    }

    public function testSetActivityTitle(): void
    {
        $section = $this->getSection();

        $section->setActivityTitle('Setting section title');

        $this->assertSame('Setting section title', $section->getActivityTitle());
    }

    public function testSetSubTitle(): void
    {
        $section = $this->getSection();

        $section->setActivitySubtitle('Setting section subtitle');

        $this->assertSame('Setting section subtitle', $section->getActivitySubtitle());
    }

    public function testSetText(): void
    {
        $section = $this->getSection();

        $section->setActivityText('Adding a new text');

        $this->assertSame('Adding a new text', $section->getActivityText());
    }

    public function testSetActivityImage(): void
    {
        $section = $this->getSection();

        $section->setActivityImage('https://teamsnodesample.azurewebsites.net/static/img/image5.png');

        $this->assertSame('https://teamsnodesample.azurewebsites.net/static/img/image5.png', $section->getActivityImage());
    }

    public function testSetMarkDown(): void
    {
        $section = $this->getSection();

        $section->setMarkDown(true);
        $this->assertTrue($section->isMarkdown());

        $section->setMarkDown(false);
        $this->assertFalse($section->isMarkdown());
    }

    public function testAddFact(): void
    {
        $section = $this->getSection();

        $section->addFact('DueDate', 'Tomorrow');

        $this->assertSame([
            'name' => 'DueDate',
            'value' => 'Tomorrow',
        ], $section->getFacts()[0]);
    }

    public function testClearFacts(): void
    {
        $section = $this->getSection();

        $section->addFact('DueDate', 'Tomorrow');

        $section->clearFacts();

        $this->assertSame([], $section->getFacts());
    }

    public function testToArray(): void
    {
        $section = $this->getSection();

        $section->addFact('DueDate', 'Tomorrow')
            ->setActivityImage('https://teamsnodesample.azurewebsites.net/static/img/image5.png')
            ->setActivityText('Adding a new text')
            ->setActivitySubtitle('Adding a subtitle')
            ->setMarkDown(false);

        $expectedData = [
            'activityTitle' => 'Section title',
            'activitySubtitle' => 'Adding a subtitle',
            'activityText' => 'Adding a new text',
            'activityImage' => 'https://teamsnodesample.azurewebsites.net/static/img/image5.png',
            'markdown' => false,
            'facts' => [
                [
                    'name' => 'DueDate',
                    'value' => 'Tomorrow',
                ],
            ],
        ];

        $this->assertSame($expectedData, $section->toArray());
    }

    protected function getSection(): Section
    {
        return new Section('Section title');
    }
}
