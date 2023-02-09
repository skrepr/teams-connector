<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 *
 * @internal
 */
final class RequestBuilder
{
    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->streamFactory = $streamFactory ?? new Psr17Factory();
        $this->requestFactory = $requestFactory ?? ($this->streamFactory instanceof RequestFactoryInterface ? $this->streamFactory : new Psr17Factory());
    }

    /**
     * Creates a new PSR-7 request.
     *
     * @param array<string, string> $headers
     * @param StreamInterface|string|null $body
     */
    public function create(string $method, string $uri, array $headers = [], $body = null): RequestInterface
    {
        $request = $this->requestFactory->createRequest($method, $uri);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($body !== null) {
            if (!$body instanceof StreamInterface) {
                $body = $this->streamFactory->createStream($body);
            }

            $request = $request->withBody($body);
        }

        return $request;
    }
}
