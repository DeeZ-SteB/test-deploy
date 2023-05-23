<?php

namespace App\Services\ResumesParsers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class DjinniResumesParser
{
    const AUTH_URL = 'https://djinni.co/login?lang=uk';
    const AUTH_TRIGGER = 'Увійти';
    const AUTH_LOGIN = 'rusleqtsexspgokvzu@bbitj.com';
    const AUTH_PASS = '123456';

    const BASE_URL = 'https://djinni.co';
    const CANDIDATES_URL = self::BASE_URL . '/developers/?';

    const EMPTY_RESPONSE = [];

    const SOURCE_NAME = 'djinni';

    const PARAMS_MAP = [
        'exp' => [
            0 => ['exp_from' => 0, 'exp_to' => 1],
            1 => ['exp_from' => 1, 'exp_to' => 2],
            2 => ['exp_from' => 2, 'exp_to' => 3],
            3 => ['exp_from' => 3, 'exp_to' => 5],
            4 => ['exp_from' => 5],
        ],
    ];

    private $params;
    private $client;

    public function __construct($params, Client $client = null)
    {
        $this->params = $params;
        $this->client = $client ?: new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
    }

    public function parse(): array
    {
        $paramsArr = $this->mapParams();

        return [
            'results' => $this->get($paramsArr),
            'next'    => ++$paramsArr['page']
        ];
    }

    private function mapParams(): array
    {
        $paramsArr = [];

        if (isset($this->params['title']) && $this->params['title']) {
            $paramsArr[] = ['title' => $this->params['title']];
        }

        if (isset($this->params['exp']) && isset(self::PARAMS_MAP['exp'][$this->params['exp']])) {
            $paramsArr[] = self::PARAMS_MAP['exp'][$this->params['exp']];
        }

        if (isset($this->params['salary_from']) && $this->params['salary_from']) {
            $paramsArr[] = ['salary_min' => $this->params['salary_from']];
        }

        if (isset($this->params['salary_to']) && $this->params['salary_to']) {
            $paramsArr[] = ['salary_max' => $this->params['salary_to']];
        }

        if (isset($this->params['location']) && $this->params['location']) {
            $paramsArr[] = ['location' => $this->params['location']];
        }

        if (isset($this->params['english']) && $this->params['english']) {
            $paramsArr[] = ['english_level' => $this->params['english']];
        }

        $paramsArr[] = ['page' => $this->params['page'] ?? 1];

        return array_merge(...$paramsArr);
    }

    private function get($paramsArr): array
    {
        $this->login();

        $url = $this->buildUrl($paramsArr);

        $crawler = $this->client->request('GET', $url);

        $pagLinks = $crawler->filter('.page-link');

        $lastPage = 1;
        if ($pagLinks->count()) {
            $count = $pagLinks->count();

            $lastPage = $pagLinks->eq(($count - 1))->text() ? $pagLinks->eq(($count - 1))->text() : $pagLinks->eq(($count - 2))->text();
        }

        if ($paramsArr['page'] > $lastPage) {
            return self::EMPTY_RESPONSE;
        }

        $cards = $crawler->filter('.card-body');

        return $cards->count() ? $crawler->filter('.card-body')->each(function ($node) {
            $link = $node->filter('.profile');
            $urlArray = explode('?', $link->attr('href'));
            $url = self::BASE_URL . $urlArray[0];

            $salaryBlock = $node->filter('h2')->first();
            $salary = $salaryBlock ? $salaryBlock->text() : '';

            return [
                'text'   => $link->text(),
                'url'    => $url,
                'salary' => $this->getAmount($salary),
                'type'   => self::SOURCE_NAME,
            ];
        }) : self::EMPTY_RESPONSE;
    }

    private function login(): void
    {
        $this->client->request('GET', self::AUTH_URL);

        $this->client->submitForm(self::AUTH_TRIGGER, [
            'email'    => self::AUTH_LOGIN,
            'password' => self::AUTH_PASS
        ]);
    }

    private function buildUrl($paramsArr): string
    {
        return self::CANDIDATES_URL . http_build_query($paramsArr);
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
