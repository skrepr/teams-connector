<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
interface CardInterface
{
    public const STATUS_SUCCESS = '#01BC36';

    public const STATUS_DEFAULT = '#0076D7';

    public const STATUS_FAILURE = '#FF0000';

    public function toArray(): array;
}
