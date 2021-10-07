<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Exception;

use RuntimeException;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
final class InvalidCredentials extends RuntimeException implements ExceptionInterface
{
}
