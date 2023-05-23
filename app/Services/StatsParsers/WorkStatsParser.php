<?php

namespace App\Services\StatsParsers;

use Goutte\Client;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpClient\HttpClient;

class WorkStatsParser
{
    const BASE_URL = 'https://www.work.ua';
    const SALARIES_URL = 'https://www.work.ua/salary';

    const LOCATIONS = [
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
    ];

    const SOURCE_NAME = 'work';

    const EMPTY_RESPONSE = [];

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

        $url = $this->buildUrl($paramsArr);

        $crawler = $this->client->request('GET', $url);

        $titles = $crawler->filter('a.card');

        if (!$titles->count()) {
            return self::EMPTY_RESPONSE;
        }

        $titleUrl = self::BASE_URL . $titles->first()->attr('href');

        $crawler = $this->client->request('GET', $titleUrl);

        $cards = $crawler->filter('.chart-vertical-bar');

        $quartile1 = $this->calcSalary($cards->first()->attr('data-max'));
        $quartile3 = $this->calcSalary($cards->last()->attr('data-min'));

        $median = $this->calcSalary(str_replace(' грн', '', $crawler->filter('.card .h1')->first()->text()));

        return [
            'stat' => ['-' => ['median' => $median, 'quartile1' => $quartile1, 'quartile3' => $quartile3]],
            'type' => self::SOURCE_NAME
        ];
    }

    private function mapParams()
    {
        $paramsArr = [['count' => 'by-resumes']];

        if (isset($this->params['title']) && $this->params['title']) {
            $paramsArr[] = ['search' => $this->params['title']];
        }

        return array_merge(...$paramsArr);
    }

    private function buildUrl($paramsArr): string
    {
        return self::SALARIES_URL . '?' . http_build_query($paramsArr);
    }

    private function calcSalary($string)
    {
        return round($string / Session::get('currencyRates')[1]['sale'], 0);
    }
}
