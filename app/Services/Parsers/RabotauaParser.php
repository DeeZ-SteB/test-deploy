<?php

namespace App\Services\Parsers;

use App\Types\CandidateExperience;

class RabotauaParser extends Parser
{
    public function pars(string $type): array
    {
        switch ($type) {
            case self::OPT_COLLECTED_CANDIDATES:
                return [
                    [
                        'name' => CandidateExperience::EXP_1_YEAR,
                        'data' => [2.11, 2.22, 2.39, 2.36, 2.59, 2.67, 1.1, 2.62, 2.67],
                    ],
                    [
                        'name' => CandidateExperience::EXP_2_YEAR,
                        'data' => [1.92, 1.7, 1.14, 1.31, 1.41, 1.6, 1.49, 1.02, 1.43],
                    ],
                    [
                        'name' => CandidateExperience::EXP_3_YEAR,
                        'data' => [1.83, 1.84, 1.77, 1.75, 1.83, 1.8, 1.79, 1.53, 1.57],
                    ],
                    [
                        'name' => CandidateExperience::EXP_5_YEAR,
                        'data' => [5.76, 5.91, 5.72, 5.76, 5.18, 5.08, 6.09, 6.43, 6.41],
                    ],
                    [
                        'name' => CandidateExperience::EXP_NO_EXP,
                        'data' => [20.19, 21.03, 19.87, 19.95, 20.63, 23.1, 24.05, 23.3, 24.7],
                    ],
                ];
            default:
                return [
                    'name' => 'rabotaua_no_data',
                    'data' => [],
                ];
        }
    }
}
