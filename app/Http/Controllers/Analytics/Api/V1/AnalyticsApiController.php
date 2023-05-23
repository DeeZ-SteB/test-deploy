<?php

namespace App\Http\Controllers\Analytics\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Analitics\GetAllDataForChartsRequest;
use App\Services\Analytics\ChartSeriesService;
use App\Services\Analytics\DatePeriodService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AnalyticsApiController extends ApiController
{
    /**
     * @param GetAllDataForChartsRequest $request
     * @param DatePeriodService $datePeriodService
     * @return \Illuminate\Http\JsonResponse
     */
    public function allChartsData(
        GetAllDataForChartsRequest $request,
        DatePeriodService          $datePeriodService,
    ): JsonResponse
    {
        try {
            $weeklyPeriods = $datePeriodService->generateWeekly($request->date_start, $request->date_end);

            $chartSeriesService = new ChartSeriesService(
                $request->spec_pos,
                $request->exp,
                $request->date_start,
                $request->date_end
            );

            $chartsData = [
                'candidatesPerJobs' => $chartSeriesService->getCandidatesPerJobs(),
                'jobsOnline' => [],
            ];

            return response()->json([
                'status'        => 'success',
                'code'          => Response::HTTP_OK,
                'weeklyPeriod'  => $weeklyPeriods->getFormatDates(),
                'charts'        => $chartsData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'code'      => Response::HTTP_BAD_REQUEST,
                'errors'    => $e->getMessage(),
            ]);
        }
    }
}
