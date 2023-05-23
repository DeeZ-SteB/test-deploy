<?php

namespace App\Http\Controllers\Pages\Analytics;

use App\Http\Controllers\Controller;
use App\Services\Analytics\DatePeriodService;
use App\Types\CandidateExperience;
use App\Types\CandidateSpecializationPosition;
use Carbon\Carbon;
use Illuminate\View\View;

class AnalyticsPageController extends Controller
{
    private CandidateSpecializationPosition $candidateSpecializationPositionTypes;
    private CandidateExperience $candidateExperienceTypes;

    public function __construct(
        CandidateSpecializationPosition $candidateSpecializationPositionTypes,
        CandidateExperience $candidateExperienceTypes
    )
    {
        $this->candidateSpecializationPositionTypes = $candidateSpecializationPositionTypes;
        $this->candidateExperienceTypes = $candidateExperienceTypes;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
//        $datePeriodService = new DatePeriodService();
//        $dateStartRaw = '2023-03-21T07:20:15.101496Z';
//        $dateEndRaw = '2023-05-23T07:22:20.674122Z';
//        $weekly = $datePeriodService->generateWeekly($dateStartRaw, $dateEndRaw);
//        dd($weekly->getFormatDates());

        $filters = [
            'experience'                => $this->candidateExperienceTypes->allExperiences(),
            'specializationPosition'    => $this->candidateSpecializationPositionTypes->allSpecializationPosition(),
            'periodStart'               => Carbon::now()->subWeeks(7),
            'periodEnd'                 => Carbon::now(),
        ];

        return view('pages.analitics', [
            'analiticFilters' => $filters,
        ]);
    }
}
