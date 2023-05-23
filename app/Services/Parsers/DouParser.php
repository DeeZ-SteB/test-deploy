<?php

namespace App\Services\Parsers;

use App\Types\CandidateExperience;

class DouParser extends Parser
{
    public function pars(string $type): array
    {
        switch ($type) {
            case self::OPT_COLLECTED_CANDIDATES:
                return [
                    [
                        'name' => CandidateExperience::EXP_1_YEAR,
                        'data' => [5.21, 5.22, 5.49, 5.56, 5.69, 5.77, 3.71, 5.72, 5.77],
                    ],
                    [
                        'name' => CandidateExperience::EXP_2_YEAR,
                        'data' => [4.12, 4.8, 4.24, 4.41, 4.51, 4.7, 4.59, 4.12, 4.53],
                    ],
                    [
                        'name' => CandidateExperience::EXP_3_YEAR,
                        'data' => [3.00, 3.11, 3.27, 3.45, 3.53, 3.6, 3.69, 3.82, 3.83],
                    ],
                    [
                        'name' => CandidateExperience::EXP_5_YEAR,
                        'data' => [8.26, 8.61, 8.62, 8.66, 8.68, 8.88, 8.99, 9.13, 9.06],
                    ],
                    [
                        'name' => CandidateExperience::EXP_NO_EXP,
                        'data' => [32.89, 33.93, 32.67, 31.75, 32.73, 35.2, 36.05, 35.4, 36.8],
                    ],
                ];
            default:
                return [
                    [
                        'name' => 'dou_no_data',
                        'data' => [],
                    ]
                ];
        }
    }
}
