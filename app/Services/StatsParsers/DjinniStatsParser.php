<?php

namespace App\Services\StatsParsers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class DjinniStatsParser
{
    const BASE_URL = 'https://djinni.co/salaries';

    const CATEGORIES = [
        'JavaScript' => 'javascript',
        'Java'       => 'java',
        'Python'     => 'python',
        'PHP'        => 'php',
        'Node.js'    => 'node.js',
        'iOS'        => 'ios',
        'Android'    => 'android',
        'C++'        => 'cplusplus',
        'Flutter'    => 'flutter',
        'Golang'     => 'golang',
        'Ruby'       => 'ruby',
        'Scala'      => 'scala',
        'Salesforce' => 'salesforce',
        'Rust'       => 'rust',
    ];

    const EMPTY_RESPONSE = [];

    const SOURCE_NAME = 'djinni';

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

        $salaryRange = $crawler->filter('.summary-stastistics--item_candidates .summary-item_range .summary-item--value');

        if (!$salaryRange->count()) {
            return self::EMPTY_RESPONSE;
        }

        preg_match_all('/\d+/', $salaryRange->text(), $matches);

        if (count($matches[0]) !== 2) {
            return self::EMPTY_RESPONSE;
        }

        $quartile1 = intval($matches[0][0]);
        $quartile3 = intval($matches[0][1]);
        $median = round(($quartile1 + $quartile3) / 2);

        return [
            'stat' => ['-' => ['median' => $median, 'quartile1' => $quartile1, 'quartile3' => $quartile3]],
            'type' => self::SOURCE_NAME
        ];
    }

    private function mapParams()
    {
        $paramsArr = [];

        if (isset($this->params['exp'])) {
            $paramsArr[] = ['exp' => $this->params['exp']];
        }

        if (isset($this->params['english']) && $this->params['english']) {
            $paramsArr[] = ['english' => $this->params['english']];
        }

        $paramsArr[] = ['page' => $this->params['page'] ?? 1];

        return array_merge(...$paramsArr);
    }

    private function buildUrl($paramsArr): string
    {
        $url = self::BASE_URL;

        if (isset($this->params['title']) && isset(self::CATEGORIES[$this->params['title']])) {
            $url .= '/' . self::CATEGORIES[$this->params['title']];
        }

        if (isset($this->params['location'])) {
            $url .= '/' . $this->params['location'];
        }

        return $url . '?' . http_build_query($paramsArr);
    }
}
