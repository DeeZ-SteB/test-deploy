<?php

namespace App\Services\Parsers;

abstract class Parser
{
    public const OPT_COLLECTED_CANDIDATES = 'Candidates per job';
    public const OPT_COLLECTED_ONLINE = 'Jobs online';
    public const OPT_COLLECTED_SEARCJ = 'Candidates in search';

    abstract public function pars(string $type): array;
}
