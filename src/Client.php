<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr18ClientDiscovery;
use LogicException;
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
        if ($client === null) {
            try {
                $client = Psr18ClientDiscovery::find();
            } catch (NotFoundException $e) {
                throw new LogicException('Could not find any installed HTTP clients. Try installing a package for this list: https://packagist.org/providers/psr/http-client-implementation', 0, $e);
            }
        }

        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
        $this->endPoint = $endPoint;
        $this->client = $client;
    }

    public function getEndPoint(): string
    {
        return $this->endPoint;
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function send(CardInterface $card): void
    {
        $request = $this->createRequest($card);

        $response = $this->client->sendRequest($request);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 401 || $statusCode === 403) {
            throw new InvalidCredentials();
        } elseif ($statusCode >= 300) {
            throw new InvalidServerResponse((string) $request->getUri(), $statusCode);
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
