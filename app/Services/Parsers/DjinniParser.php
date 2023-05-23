<?php

namespace App\Services\Parsers;

use App\Types\CandidateExperience;

class DjinniParser extends Parser
{
    public function pars(string $type): array
    {
        switch ($type) {
            case self::OPT_COLLECTED_CANDIDATES:
                return [
                    [
                        'name' => CandidateExperience::EXP_1_YEAR,
                        'data' => [4.11, 4.22, 4.39, 4.36, 4.59, 4.67, 2.61, 4.62, 4.67],
                    ],
                    [
                        'name' => CandidateExperience::EXP_2_YEAR,
                        'data' => [3.02, 3.7, 3.14, 3.31, 3.41, 3.6, 3.49, 3.02, 3.43],
                    ],
                    [
                        'name' => CandidateExperience::EXP_3_YEAR,
                        'data' => [2.00, 2.01, 2.17, 2.35, 2.43, 2.5, 2.59, 2.72, 2.73],
                    ],
                    [
                        'name' => CandidateExperience::EXP_5_YEAR,
                        'data' => [7.16, 7.51, 7.52, 7.56, 7.58, 7.78, 7.89, 8.03, 8.01],
                    ],
                    [
                        'name' => CandidateExperience::EXP_NO_EXP,
                        'data' => [22.79, 23.83, 22.57, 21.65, 22.63, 25.1, 26.05, 25.3, 26.7],
                    ],
                ];
            default:
                return [
                    [
                        'name' => 'djinni_no_data',
                        'data' => [],
                    ]
                ];
        }
    }
}
