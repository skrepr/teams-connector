<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

use FriendsOfPHP\WellKnownImplementations\WellKnownPsr18Client;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Skrepr\TeamsConnector\Exception\InvalidCredentials;
use Skrepr\TeamsConnector\Exception\InvalidServerResponse;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class Client
{
    private string $endPoint;

    private ClientInterface $client;

    private RequestBuilder $requestBuilder;

    public function __construct(
        string $endPoint,
        ClientInterface $client = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->endPoint = $endPoint;
        $this->client = $client ?? new WellKnownPsr18Client();
        $this->requestBuilder = $requestBuilder ?? new RequestBuilder();
    }

    public function getEndPoint(): string
    {
        return $this->endPoint;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function send(CardInterface $card): void
    {
        $request = $this->createRequest($card);

        $response = $this->client->sendRequest($request);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 401 || $statusCode === 403) {
            throw new InvalidCredentials();
        } elseif ($statusCode >= 300) {
            throw new InvalidServerResponse((string) $response->getBody(), $statusCode);
        }

        if ($response->getBody()->getContents() !== '1') {
            throw new InvalidServerResponse('Something went wrong!');
        }
    }

    private function createRequest(CardInterface $card): RequestInterface
    {
        $content = json_encode($card->toArray());

        return $this->requestBuilder->create(
            'POST',
            $this->endPoint,
            ['Content-Type' => 'application/json', 'Content-Length' => strlen($content)],
            $content
        );
    }
}
