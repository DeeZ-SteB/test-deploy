<?php

namespace App\Services\Analytics;

use App\Services\Parsers\DjinniParser;
use App\Services\Parsers\DouParser;
use App\Services\Parsers\Parser;
use App\Services\Parsers\RabotauaParser;
use App\Services\Parsers\WorkuaParser;
use App\Types\CandidateExperience;

class ChartSeriesService
{
    private string $specializationPosition;
    private array $experience;
    private string $startDate;
    private string $endDate;

    public function __construct(string $specializationPosition, array $experience, string $startDate, string $endDate)
    {
        $this->specializationPosition = $specializationPosition;
        $this->experience = $experience;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return array
     */
    public function getCandidatesPerJobs(): array
    {
        $parserDou = new DouParser();
        $parserDjinni = new DjinniParser();
        $parserWorkua = new WorkuaParser();
        $parserRabotaua = new RabotauaParser();

        return [
            'dou'      => $parserDou->pars(Parser::OPT_COLLECTED_CANDIDATES),
            'djinni'   => $parserDjinni->pars(Parser::OPT_COLLECTED_CANDIDATES),
            'workua'   => $parserWorkua->pars(Parser::OPT_COLLECTED_CANDIDATES),
            'rabotaua' => $parserRabotaua->pars(Parser::OPT_COLLECTED_CANDIDATES),
        ];
    }
}
