<?php

namespace App\Services\StatsParsers;

class DouStatsParser
{
    const PARAMS_MAP = [
        'title'    => [
            'JavaScript' => 'JavaScript',
            'Java'       => 'Java',
            '.NET'       => 'C#/.NET',
            'Python'     => 'Python',
            'PHP'        => 'PHP',
            'C++'        => 'C++',
            'Golang'     => 'Golang',
            'Ruby'       => 'Ruby',
            'Scala'      => 'Scala',
            'Salesforce' => 'Salesforce',
            'Rust'       => 'Rust',
        ],
        'exp'      => [
            0 => ['from' => 0, 'to' => 0],
            1 => ['from' => 1, 'to' => 2],
            2 => ['from' => 2, 'to' => 3],
            3 => ['from' => 3, 'to' => 5],
            4 => ['from' => 5, 'to' => 100],
        ],
        'location' => [
            'kyiv'            => 1,
            'vinnytsia'       => 2,
            'dnipro'          => 3,
            'ivano-frankivsk' => 7,
            'zhytomyr'        => 5,
            'zaporizhzhia'    => 6,
            'lviv'            => 12,
            'mykolaiv'        => 14,
            'odesa'           => 15,
            'ternopil'        => 21,
            'kharkiv'         => 24,
            'khmelnytskyi'    => 26,
            'cherkasy'        => 27,
            'chernihiv'       => 29,
            'chernivtsi'      => 28,
            'uzhhorod'        => 23,
        ],
        'english'  => [
            'basic'        => 1,
            'pre'          => 2,
            'intermediate' => 3,
            'upper'        => 4,
            'fluent'       => 5,
        ],
        'grade' => [
            'trainee' => 'Intern/Trainee SE',
            'junior' => 'Junior SE',
            'middle' => 'Middle SE',
            'senior' => 'Senior SE',
        ],
    ];

    const DATA_TABLES = [
        'trainee' => 'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev.csv',
        'junior' => 'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev-junior.csv',
        'middle' => 'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev-middle.csv',
        'senior' => 'https://s.dou.ua/files/lenta/salary-widget_dec_2022/data/swd-dev-senior.csv',
    ];

    const SOURCE_NAME = 'dou';

    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function parse()
    {
        $paramsArr = $this->mapParams();

        $sources = [];
        foreach (self::DATA_TABLES as $key => $table) {
            if (!isset($this->params['grade']) || $key == $this->params['grade']) {
                $sources[] = $table;
            }
        }

        $candidates = [];

        foreach ($sources as $source) {
            if (($handle = fopen($source, 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    if (
                        $row[10] == '2022-12' &&
                        (!isset($paramsArr['location']) || $paramsArr['location'] == $row[2]) &&
                        (!isset($paramsArr['exp']) || ($row[4] >= $paramsArr['exp']['from'] && $row[4] <= $paramsArr['exp']['to'])) &&
                        (!isset($paramsArr['english']) || $paramsArr['english'] == $row[6]) &&
                        (!isset($paramsArr['grade']) || $paramsArr['grade'] == $row[0]) &&
                        (!isset($paramsArr['title']) || $paramsArr['title'] == $row[8])
                    ) {
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
            'type' => self::SOURCE_NAME,
        ];
    }

    private function mapParams()
    {
        $paramsArr = [];

        if (isset($this->params['title']) && isset(self::PARAMS_MAP['title'][$this->params['title']])) {
            $paramsArr[] = ['title' => self::PARAMS_MAP['title'][$this->params['title']]];
        }

        if (isset($this->params['location']) && isset(self::PARAMS_MAP['location'][$this->params['location']])) {
            $paramsArr[] = ['location' => self::PARAMS_MAP['location'][$this->params['location']]];
        }

        if (isset($this->params['exp']) && isset(self::PARAMS_MAP['exp'][$this->params['exp']])) {
            $paramsArr[] = ['exp' => self::PARAMS_MAP['exp'][$this->params['exp']]];
        }

        if (isset($this->params['english']) && isset(self::PARAMS_MAP['english'][$this->params['english']])) {
            $paramsArr[] = ['english' => self::PARAMS_MAP['english'][$this->params['english']]];
        }

        if (isset($this->params['grade']) && isset(self::PARAMS_MAP['grade'][$this->params['grade']])) {
            $paramsArr[] = ['grade' => self::PARAMS_MAP['grade'][$this->params['grade']]];
        }

        return array_merge(...$paramsArr);
    }

    private function calcQuartiles($data)
    {
        sort($data);
        $count = count($data);

        $median = ($count % 2 == 0) ? ($data[$count / 2 - 1] + $data[$count / 2]) / 2 : $data[floor($count / 2)];

        $lowerHalf = array_slice($data, 0, floor($count / 2));
        if (count($lowerHalf) / 2 - 1 >= 0) {
            $q1 = (count($lowerHalf) % 2 == 0) ? ($lowerHalf[count($lowerHalf) / 2 - 1] + $lowerHalf[count($lowerHalf) / 2]) / 2 : $lowerHalf[floor(count($lowerHalf) / 2)];
        } else {
            $q1 = '';
        }

        $upperHalf = array_slice($data, ceil($count / 2));
        if (count($upperHalf) % 2 - 1 >= 0) {
            $q3 = (count($upperHalf) % 2 == 0) ? ($upperHalf[count($upperHalf) / 2 - 1] + $upperHalf[count($upperHalf) / 2]) / 2 : $upperHalf[floor(count($upperHalf) / 2)];
        } else {
            $q3 = '';
        }


        return ['median' => $median, 'quartile1' => $q1, 'quartile3' => $q3];
    }
}
