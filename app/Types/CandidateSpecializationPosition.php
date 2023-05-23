<?php

namespace App\Types;

class CandidateSpecializationPosition
{
    // SP - Specialization/Position
    public const SP_SOFTWARE_ENGINEER_TRAIN = 'sp_software_engineer_train';
    public const SP_SOFTWARE_ENGINEER_JUNIOR = 'sp_software_engineer_junior';

    public const SP_QA_TRAIN = 'sp_qa_train';
    public const SP_QA_JUNIOR = 'sp_qa_junior';
    public const SP_QA_MIDDLE = 'sp_qa_middle';
    public const SP_QA_SENIOR = 'sp_qa_senior';
    public const SP_QA_LEAD = 'sp_qa_lead';
    public const SP_QA_MANAGER = 'sp_qa_manager';

    public function allSpecializationPosition(): array
    {
        return [
            self::SP_SOFTWARE_ENGINEER_TRAIN    => 'Software Engineer: Intern/Trainee',
            self::SP_SOFTWARE_ENGINEER_JUNIOR   => 'Software Engineer: Junior',

            self::SP_QA_TRAIN   => 'QA: Intern/Trainee',
            self::SP_QA_JUNIOR  => 'QA: Junior',
            self::SP_QA_MIDDLE  => 'QA: Middle',
            self::SP_QA_SENIOR  => 'QA: Senior',
            self::SP_QA_LEAD    => 'QA: Team/Tech Lead',
            self::SP_QA_MANAGER => 'QA: Manager',
        ];
    }
}
