<?php

namespace App\Services\Parsers;

use App\Types\CandidateExperience;

class WorkuaParser extends Parser
{
    public function pars(string $type): array
    {
        switch ($type) {
            case self::OPT_COLLECTED_CANDIDATES:
                return [
                    [
                        'name' => CandidateExperience::EXP_1_YEAR,
                        'data' => [3.11, 3.22, 3.39, 3.36, 3.59, 3.67, 1.61, 3.62, 3.67],
                    ],
                    [
                        'name' => CandidateExperience::EXP_2_YEAR,
                        'data' => [2.02, 2.7, 2.14, 2.31, 2.41, 2.6, 2.49, 2.02, 2.43],
                    ],
                    [
                        'name' => CandidateExperience::EXP_3_YEAR,
                        'data' => [1.90, 1.91, 1.87, 1.85, 1.93, 1.9, 1.89, 1.62, 1.63],
                    ],
                    [
                        'name' => CandidateExperience::EXP_5_YEAR,
                        'data' => [6.16, 6.51, 6.52, 6.56, 6.58, 6.78, 6.89, 7.03, 7.01],
                    ],
                    [
                        'name' => CandidateExperience::EXP_NO_EXP,
                        'data' => [20.79, 21.83, 20.57, 20.65, 21.63, 24.1, 25.05, 24.3, 25.7],
                    ],
                ];
            default:
                return [
                    [
                        'name' => 'workua_no_data',
                        'data' => [],
                    ]
                ];
        }
    }
}
