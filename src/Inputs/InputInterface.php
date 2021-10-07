<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Inputs;

/**
 * @author Evert Jan Hakvoort <evertjan@hakvoort.io>
 */
interface InputInterface
{
    public const DATE_INPUT = 'DateInput';

    public const MULTI_CHOICE_INPUT = 'MultichoiceInput';

    public const TEXT_INPUT = 'TextInput';

    public function getId(): string;

    public function getTitle(): string;

    public function toArray(): array;
}
