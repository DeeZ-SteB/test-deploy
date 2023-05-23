<?php

namespace App\Services\ResumesParsers;

use App\Services\CurrencyRates;
use ErrorException;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class RabotaResumesParser
{
    const BASE_URL = 'https://employer-api.rabota.ua/cvdb/resumes';
    const CANDIDATE_BASE_URL = 'https://rabota.ua/ua/candidates/';

    const EMPTY_RESPONSE = [];

    const SOURCE_NAME = 'rabota';

    const PARAMS_MAP = [
        'exp'      => [
            0 => ["0", "1"],
            1 => ["2"],
            2 => ["3"], // 2-5 years, not 2-3
            3 => ["3"],
            4 => ["4", "5"],
        ],
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
        ],
        'english'  => [
            'basic'        => ["1-1", "1-2"],
            'pre'          => ["1-1", "1-2"],
            'intermediate' => ["1-3"],
            'upper'        => ["1-6"],
            'fluent'       => ["1-4", "1-5", "1-7"],
        ],
    ];

    private $params;
    private $client;

    public function __construct($params, Client $client = null)
    {
        $this->params = $params;
        $this->client = $client ?: new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
    }

    public function parse()
    {
        $paramsArr = $this->mapParams();

        return [
            'results' => $this->get($paramsArr),
            'next'    => ++$paramsArr['page']
        ];
    }

    private function mapParams()
    {
        // TODO: check all params one more time on both sides

        $paramsArr = [
            ['rubrics' => ["1"]], // `IT` category
            ['showCvWithoutSalary' => 'false'],
        ];

        if (isset($this->params['title']) && $this->params['title']) {
            $paramsArr[] = ['keyWords' => $this->params['title']];
        }

        if (isset($this->params['exp']) && isset(self::PARAMS_MAP['exp'][$this->params['exp']])) {
            $paramsArr[] = ['experienceIds' => self::PARAMS_MAP['exp'][$this->params['exp']]];
        }

        if (isset($this->params['salary_from']) && $this->params['salary_from']) {
            $salaryArr['from'] = round($this->params['salary_from'] * CurrencyRates::getUsdRate(), 0);
        }

        if (isset($this->params['salary_to']) && $this->params['salary_to']) {
            $salaryArr['to'] = round($this->params['salary_to'] * CurrencyRates::getUsdRate(), 0);
        }

        if (isset($salaryArr)) {
            $paramsArr[] = ['salary' => json_encode($salaryArr)];
        }

        if (isset($this->params['location']) && isset(self::PARAMS_MAP['location'][$this->params['location']])) {
            $paramsArr[] = ['cityId' => self::PARAMS_MAP['location'][$this->params['location']]];
        } else {
            $paramsArr[] = ['cityId' => 0]; // defaults to `All Ukraine`
        }

        if (isset($this->params['english']) && isset(self::PARAMS_MAP['english'][$this->params['english']])) {
            $paramsArr[] = ['languages' => self::PARAMS_MAP['english'][$this->params['english']]];
        }

        $paramsArr[] = ['page' => $this->params['page'] ?? 1];

        return array_merge(...$paramsArr);
    }

    private function get($paramsArr)
    {
        $url = $this->buildUrl($paramsArr);

        try {
            $data = json_decode(file_get_contents($url));
        } catch (ErrorException $e) {
            return self::EMPTY_RESPONSE;
        }

        $results = [];
        foreach ($data->documents as $person) {
            $results[] = [
                'text'   => $person->speciality,
                'url'    => self::CANDIDATE_BASE_URL . $person->resumeId,
                'salary' => $this->calcSalary($person->salary),
                'type'   => self::SOURCE_NAME
            ];
        }

        return $results;
    }

    private function buildUrl($paramsArr)
    {
        return sprintf('%s?%s', self::BASE_URL, http_build_query($paramsArr));
    }

    private function calcSalary($string)
    {
        $salary = $this->getAmount($string);

        if ($string && str_contains(strtolower($string), 'грн')) {
            return round($salary / CurrencyRates::getUsdRate(), 0);
        }

        return $salary;
    }

    private function getAmount($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '', $stringWithCommaOrDot);

        return (float)str_replace(',', '.', $removedThousandSeparator);
    }
}
