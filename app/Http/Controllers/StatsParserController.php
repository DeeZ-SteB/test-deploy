<?php

namespace App\Http\Controllers;

use App\Services\CurrencyRates;
use App\Services\StatsParsers\DouStatsParser;
use App\Services\StatsParsers\DjinniStatsParser;
use App\Services\StatsParsers\WorkStatsParser;
use App\Services\StatsParsers\RabotaStatsParser;
use Illuminate\Http\Request;
use App;

class StatsParserController extends Controller {

    public function get(Request $request)
    {
        (new CurrencyRates())->getCurrencyRates();

        $input = [
            'title'       => $request->input('title'),
            'exp'         => $request->input('exp'),
            'salary_from' => $request->input('salary_from'),
            'salary_to'   => $request->input('salary_to'),
            'location'    => $request->input('location'),
            'english'     => $request->input('english'),
            'grade'       => $request->input('grade'),
        ];

        $parsers = [
            new DouStatsParser($input),
            new DjinniStatsParser($input),
            new WorkStatsParser($input),
            new RabotaStatsParser($input),
        ];

        $results = [];

        foreach ($parsers as $parser) {
            $parserData = $parser->parse();
            if (!empty($parserData)) {
                $results = array_merge($results, [$parserData['type'] => $parserData['stat']]);
            }
        }

        return response()->json([
            'results' => $results
        ]);
    }
}
