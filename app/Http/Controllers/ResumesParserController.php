<?php

namespace App\Http\Controllers;

use App\Services\CurrencyRates;
use App\Services\ResumesParsers\DjinniResumesParser;
use App\Services\ResumesParsers\RabotaResumesParser;
use App\Services\ResumesParsers\WorkResumesParser;
use Illuminate\Http\Request;
use App;

class ResumesParserController extends Controller
{
    public function get(Request $request)
    {
        (new CurrencyRates())->getCurrencyRates();

        $page = $request->input('page') ?: 1;

        $input = [
            'title'       => $request->input('title'),
            'exp'         => $request->input('exp'),
            'salary_from' => $request->input('salary_from'),
            'salary_to'   => $request->input('salary_to'),
            'location'    => $request->input('location'),
            'english'     => $request->input('english'),
            'page'        => $page
        ];

        $parsers = [
            new DjinniResumesParser($input),
            new WorkResumesParser($input),
            new RabotaResumesParser($input),
        ];

        $results = [];
        foreach ($parsers as $parser) {
            $results[] = $parser->parse()['results'];
        }

        return response()->json([
            'results' => array_merge(...$results),
            'next'    => ++$page
        ]);
    }
}
