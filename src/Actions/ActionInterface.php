<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Actions;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
interface ActionInterface
{
    public const ACTION_CARD = 'ActionCard';

    public const HTTP_POST_ACTION = 'HttpPOST';

    public const OPEN_URI_ACTION = 'OpenUri';

    public function getName(): string;

    public function toArray(): array;
}
