<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use LogicException;
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
        if ($requestFactory === null || $streamFactory === null) {
            if (!class_exists(Psr17Factory::class) && !class_exists(Psr17FactoryDiscovery::class)) {
                throw new LogicException('You cannot use the "%s" as no PSR-17 request factory have been provided. Try running "composer require nyholm/psr7.');
            }

            try {
                $psr17Factory = class_exists(Psr17Factory::class, false) ? new Psr17Factory() : null;
                $requestFactory = $requestFactory ?? $psr17Factory ?? Psr17FactoryDiscovery::findRequestFactory();
                $streamFactory = $streamFactory ?? $psr17Factory ?? Psr17FactoryDiscovery::findStreamFactory();
            } catch (NotFoundException $e) {
                throw new LogicException('You cannot use the "%s" as no PSR-17 request factory have been provided. Try running "composer require nyholm/psr7".', 0, $e);
            }
        }

        $this->streamFactory = $streamFactory;
        $this->requestFactory = $requestFactory;
    }

    /**
     * Creates a new PSR-7 request.
     *
     * @param array $headers name => value or name=>[value]
     * @param StreamInterface|string|null $body request body
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
