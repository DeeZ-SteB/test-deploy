<?php

namespace App\Services\StatsParsers;

class DouParser
{
    protected $params;

    public function __construct()
    {
    }

    public function parse()
    {
        $filenames = [
            'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev-junior.csv',
            'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev-middle.csv',
            'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev-senior.csv',
            'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev.csv',
        ];

        $candidates = [];

        foreach ($filenames as $filename) {
            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    if ($row[10] == '2022-12') {
                        $candidates[$row[0]][] = [
                            'city'       => $row[2],
                            'exp'        => $row[4],
                            'english'    => $row[6],
                            'salary'     => $row[7],
                            'technology' => $row[8]
                        ];
                    }
                }
                fclose($handle);

                unset($candidates['position']);
            }
        }

        $response = [];

        foreach ($candidates as $key => $candidate) {
            $salaryArr = [];
            foreach ($candidate as $person) {
                $salaryArr[] = $person['salary'];
            }

            $response[$key] = $this->calcQuartiles($salaryArr);
        }

        return [
            'stat' => $response,
            'type' => 'dou'
        ];
    }

    private function calcQuartiles($data)
    {
        sort($data);
        $count = count($data);

        $median = ($count % 2 == 0) ? ($data[$count / 2 - 1] + $data[$count / 2]) / 2 : $data[floor($count / 2)];

        $lowerHalf = array_slice($data, 0, floor($count / 2));
        $q1 = (count($lowerHalf) % 2 == 0) ? ($lowerHalf[count($lowerHalf) / 2 - 1] + $lowerHalf[count($lowerHalf) / 2]) / 2 : $lowerHalf[floor(count($lowerHalf) / 2)];

        $upperHalf = array_slice($data, ceil($count / 2));
        $q3 = (count($upperHalf) % 2 == 0) ? ($upperHalf[count($upperHalf) / 2 - 1] + $upperHalf[count($upperHalf) / 2]) / 2 : $upperHalf[floor(count($upperHalf) / 2)];

        return ['median' => $median, 'quartile1' => $q1, 'quartile3' => $q3];
    }
}
