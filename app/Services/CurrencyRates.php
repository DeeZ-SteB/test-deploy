<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class CurrencyRates
{
    private $apiUrl = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=11';

    public function __construct()
    {
    }

    public function getCurrencyRates()
    {
        $client = new Client();
        $response = $client->get($this->apiUrl);

        $currencyRates = json_decode($response->getBody(), true);

        Session::put('currencyRates', $currencyRates);
    }

    public static function getUsdRate()
    {
        $rates = Session::get('currencyRates');
        if (empty($rates)) {
            return null;
        }

        return $rates[1]['sale'];
    }
}
