<?php

namespace App\Services\StatsParsers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class RabotaStatsParser
{
    const API_URL = 'https://dracula.rabota.ua?query=gettingStatisticsAverageSalary';

    const PARAMS_MAP = [
        'location' => [
            'kyiv'            => 1,
            'vinnytsia'       => 5,
            'dnipro'          => 4,
            'ivano-frankivsk' => 10,
            'zhytomyr'        => 7,
            'zaporizhzhia'    => 9,
            'lviv'            => 2,
            'mykolaiv'        => 15,
            'odesa'           => 3,
            'ternopil'        => 20,
            'kharkiv'         => 21,
            'khmelnytskyi'    => 23,
            'cherkasy'        => 24,
            'chernihiv'       => 25,
            'chernivtsi'      => 26,
            'uzhhorod'        => 28,
        ]
    ];

    const EMPTY_RESPONSE = [];

    const SOURCE_NAME = 'rabota';

    private $client;
    private $params;

    public function __construct($params, Client $client = null)
    {
        $this->params = $params;
        $this->client = $client ?: new Client();
    }

    public function parse()
    {
        $query = 'query gettingStatisticsAverageSalary($keyword: String!, $cityId: ID!, $rubricId: ID, $range: DateIntervalInput!, $period: PeriodType!) {
                      keyword(name: $keyword) {
                        name
                        statistic(
                          input: {cityId: $cityId, rubricId: $rubricId, period: $period, range: $range, keyword: $keyword}
                        ) {
                          ...StatisticsAverageSalaryData
                          __typename
                        }
                        __typename
                      }
                    }

                    fragment StatisticsAverageSalaryData on StatisticData {
                      vacancy {
                        ...GettingStatisticsAverageSalary
                        __typename
                      }
                      candidate {
                        ...GettingStatisticsAverageSalary
                        __typename
                      }
                      __typename
                    }

                    fragment GettingStatisticsAverageSalary on StatisticItem {
                      total {
                        count
                        salary
                        salaryMax
                        salaryMin
                        __typename
                      }
                      median {
                        begin
                        end
                        value
                        __typename
                      }
                      __typename
                    }
                    ';

        $payload = [
            'query'         => $query,
            'variables'     => [
                'keyword'  => $this->params['title'] ?? '',
                'cityId'   => $this->params['location'] ? self::PARAMS_MAP['location'][$this->params['location']] : 0,
                'rubricId' => 1,
                'range'    => ['begin' => '2023-01-31T22:00:00.000Z'],
                'period'   => 'MONTH',
            ],
            'operationName' => "gettingStatisticsAverageSalary"
        ];

        $crawler = $this->client->request('POST', self::API_URL, [
            'headers' => ['Content-Type' => 'application/json'],
            'body'    => json_encode($payload),
        ]);

        $response = json_decode($crawler->getBody()->getContents());

        $quartile1 = $this->calcSalary($response->data->keyword->statistic->vacancy->total->salaryMin);
        $quartile3 = $this->calcSalary($response->data->keyword->statistic->vacancy->total->salaryMax);
        $median = $this->calcSalary($response->data->keyword->statistic->vacancy->total->salary);

        return [
            'stat' => ['-' => ['median' => $median, 'quartile1' => $quartile1, 'quartile3' => $quartile3]],
            'type' => self::SOURCE_NAME
        ];
    }

    private function calcSalary($string)
    {
        return round($string / Session::get('currencyRates')[1]['sale'], 0);
    }
}
