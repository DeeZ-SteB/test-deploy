<?php

namespace App\Types;

class CandidateExperience
{
    public const EXP_ALL = 'exp_all';

    public const EXP_1_YEAR = 'exp_one_year';
    public const EXP_2_YEAR = 'exp_two_years';
    public const EXP_3_YEAR = 'exp_three_years';
    public const EXP_5_YEAR = 'exp_five_years';
    public const EXP_NO_EXP = 'exp_no_exp';

    /**
     * @return string[]
     */
    public function allExperiences(): array
    {
        return [
            self::EXP_1_YEAR => '1y',
            self::EXP_2_YEAR => '2y',
            self::EXP_3_YEAR => '3y',
            self::EXP_5_YEAR => '5y',
            self::EXP_NO_EXP => 'No Exp',
        ];
    }
}
