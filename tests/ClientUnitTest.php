<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Tests;

use PHPUnit\Framework\TestCase;
use Skrepr\TeamsConnector\Client;

final class ClientUnitTest extends TestCase
{
    public function testInstantiation(): void
    {
        $client = $this->createClient();

        $this->assertSame('http://fake.endpoint', $client->getEndPoint());
    }

    private function createClient(): Client
    {
        return new Client('http://fake.endpoint');
    }
}
