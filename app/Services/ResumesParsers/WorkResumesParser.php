<?php

namespace App\Services\ResumesParsers;

use App\Services\CurrencyRates;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class WorkResumesParser
{
    const BASE_URL = 'https://www.work.ua/resumes';
    const CANDIDATE_BASE_URL = 'https://www.work.ua';

    const EMPTY_RESPONSE = [];

    const SALARY_FILTER_OPTIONS = [
        2  => 2000,
        3  => 3000,
        4  => 4000,
        5  => 5000,
        6  => 6000,
        7  => 7000,
        8  => 8000,
        9  => 9000,
        10 => 10000,
        11 => 15000,
        12 => 20000,
        13 => 25000,
        14 => 30000,
        15 => 40000,
        16 => 50000,
        17 => 100000,
        18 => PHP_INT_MAX,
    ];

    const PARAMS_MAP = [
        'exp'      => [
            0 => '1',
            1 => '164',
            2 => '165', // 2-5 years, not 2-3
            3 => '165',
            4 => '166',
        ],
        'location' => [
            'kyiv'            => 'kyiv',
            'vinnytsia'       => 'vinnytsya',
            'dnipro'          => 'dnipro',
            'ivano-frankivsk' => 'ivano-frankivsk',
            'zhytomyr'        => 'zhytomyr',
            'zaporizhzhia'    => 'zaporizhzhya',
            'lviv'            => 'lviv',
            'mykolaiv'        => 'mykolaiv_nk',
            'odesa'           => 'odesa',
            'ternopil'        => 'ternopil',
            'kharkiv'         => 'kharkiv',
            'khmelnytskyi'    => 'khmelnytskyi',
            'cherkasy'        => 'cherkasy',
            'chernihiv'       => 'chernihiv',
            'chernivtsi'      => 'chernivtsi_cv',
            'uzhhorod'        => 'uzhhorod',
        ],
        'english'  => [
            'basic'        => '1-83',
            'pre'          => '1-83',
            'intermediate' => '1-84',
            'upper'        => '1-22835',
            'fluent'       => '1-22836+1-85',
        ],
    ];

    const SOURCE_NAME = 'work';

    private $params;

    public function __construct($params)
    {
        $this->params = $params;
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
        $paramsArr = [
            ['category' => '1'] // `IT` category
        ];

        if (isset($this->params['title']) && $this->params['title']) {
            $paramsArr[] = ['search' => $this->params['title']];
        }

        if (isset($this->params['exp']) && isset(self::PARAMS_MAP['exp'][$this->params['exp']])) {
            $paramsArr[] = ['experience' => self::PARAMS_MAP['exp'][$this->params['exp']]];
        }

        if (isset($this->params['salary_from']) && $this->params['salary_from']) {
            $paramsArr[] = ['salaryfrom' => $this->findSalaryOption(round($this->params['salary_from'] * CurrencyRates::getUsdRate(), 0))];
        }

        if (!isset($paramsArr['salaryfrom']) || $paramsArr['salaryfrom'] === null) {
            $paramsArr[] = ['salaryfrom' => 2];
        }

        if (isset($this->params['salary_to']) && $this->params['salary_to']) {
            $paramsArr[] = ['salaryto' => $this->findSalaryOption(round($this->params['salary_to'] * CurrencyRates::getUsdRate(), 0))];
        }

        if (isset($this->params['location']) && isset(self::PARAMS_MAP['location'][$this->params['location']])) {
            $paramsArr[] = ['region' => self::PARAMS_MAP['location'][$this->params['location']]];
        }

        if (isset($this->params['english']) && isset(self::PARAMS_MAP['english'][$this->params['english']])) {
            $paramsArr[] = ['language' => '1'];
            $paramsArr[] = ['language_level' => self::PARAMS_MAP['english'][$this->params['english']]];
        }

        $paramsArr[] = ['page' => $this->params['page'] ?? 1];

        return array_merge(...$paramsArr);
    }

    private function findSalaryOption(int $sum): ?int
    {
        foreach (self::SALARY_FILTER_OPTIONS as $key => $rate) {
            if ($sum > $rate && isset(self::SALARY_FILTER_OPTIONS[($key - 1)])) {
                return ($key - 1);
            }
        }

        return null;
    }

    private function get($paramsArr)
    {
        $client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));

        $url = $this->buildUrl($paramsArr);

        $crawler = $client->request('GET', $url);

        $cards = $crawler->filter('.resume-link');

        return empty($cards) ? self::EMPTY_RESPONSE : $cards->each(function ($node) {
            $link = $node->filter('h2 a');

            $salaryBlock = $node->filter('h2 span span')->first();
            $salary = $salaryBlock->count() ? $salaryBlock->text() : '';

            return [
                'text'   => $link->text(),
                'url'    => self::CANDIDATE_BASE_URL . $link->attr('href'),
                'salary' => $this->calcSalary($salary),
                'type'   => self::SOURCE_NAME
            ];
        });
    }

    private function buildUrl($paramsArr): string
    {
        $url = self::BASE_URL;

        if (isset($paramsArr['region'])) {
            $url .= '-' . $paramsArr['region'];
            unset($paramsArr['region']);
        }

        return sprintf('%s?%s', $url, http_build_query($paramsArr));
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
