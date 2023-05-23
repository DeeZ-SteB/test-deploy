<?php

namespace App\Http\Controllers\Widgets\Charts\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class CandidatesPerJobsApiController extends ApiController
{
    /**
     * @OA\Get(
     *      path="/api/v1/analitics/chart/candidates-per-jobs",
     *      operationId="demo",
     *      tags={"Analitics"},
     *      summary="Demo data for chart",
     *      description="Get demo data for chart",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  description="Response status message",
     *                  example="success",
     *              ),
     *              @OA\Property(
     *                  property="code",
     *                  type="integer",
     *                  description="Response status code",
     *                  example="200",
     *              ),
     *              @OA\Property(
     *                  property="chart",
     *                  type="object",
     *                  @OA\Property(
     *                      property="labels",
     *                      type="array",
     *                      @OA\Items(type="string"),
     *                  ),
     *                  @OA\Property(
     *                      property="dataset",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="label", type="array", @OA\Items()),
     *                          @OA\Property(property="data", type="array", @OA\Items(type="number")),
     *                          @OA\Property(property="fill", type="bool"),
     *                          @OA\Property(property="borderColor", type="string"),
     *                          @OA\Property(property="tension", type="number"),
     *                      ),
     *                 ),
     *              ),
     *          ),
     *      ),
     * )
     *
     * @alias api.v1.analitics.chart.candidates-per-jobs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function demo(): JsonResponse
    {
        sleep(1); // TODO Del this

        $demoData = [
            'labels' => [
                'Jan 30, 2023',
                'Feb 6, 2023',
                'Feb 13, 2023',
                'Feb 20, 2023',
                'Feb 27, 2023',
                'Mar 6, 2023',
                'Mar 13, 2023',
                'Mar 20, 2023',
                'Mar 27, 2023',
            ],
            'datasets' => [
                [
                    'label'           => '1y',
                    'data'            => [5.21, 5.22, 5.49, 5.56, 5.69, 5.77, 3.71, 5.72, 5.77],
                    'borderColor'     => '#649CDD', // Line chart
                ],
                [
                    'label'           => '2y',
                    'data'            => [4.12, 4.8, 4.24, 4.41, 4.51, 4.7, 4.59, 4.12, 4.53],
                    'borderColor'     => '#7272AA',
                ],
                [
                    'label'           => '3y',
                    'data'            => [3.00, 3.11, 3.27, 3.45, 3.53, 3.6, 3.69, 3.82, 3.83],
                    'borderColor'     => '#A6D7D8',
                ],
                [
                    'label'           => '5y',
                    'data'            => [8.26, 8.61, 8.62, 8.66, 8.68, 8.88, 8.99, 9.13, 9.06],
                    'borderColor'     => '#F3D570',
                ],
                [
                    'label'           => 'No exp.',
                    'data'            => [32.89, 33.93, 32.67, 31.75, 32.73, 35.2, 36.05, 35.4, 36.8],
                    'borderColor'     => '#94BD5D',
                ],
            ],
        ];

        return response()->json([
            'status'    => 'success',
            'code'      => Response::HTTP_OK,
            'chart'     => $demoData,
        ]);
    }
}
