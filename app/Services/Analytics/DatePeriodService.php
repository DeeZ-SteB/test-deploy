<?php

namespace App\Services\Analytics;

use Carbon\Carbon;

class DatePeriodService
{
    private array $periods;

    /**
     * @param string $startDate
     * @param string $endDate
     * @return $this
     * @throws \Exception
     */
    public function generateWeekly(string $startDate, string $endDate): self
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // check date period by errors $startDate must be < $endDate
        if ($start->lt($end)) {
            $this->periods[] = $this->addPariod($end);

            while ($start->lt($end)) {
                $end->subWeek();
                array_unshift($this->periods, $this->addPariod($end));
            }

            return $this;
        }

        throw new \Exception('Error generating a period by weeks.');
    }

    public function getPeriods(): array
    {
        return $this->periods;
    }

    public function getFormatDates(): array
    {
        return array_map(fn ($dateArr) => $dateArr['formatDate'], $this->periods);
    }

    private function addPariod(Carbon $carbonDate): array
    {
        return [
            'carbonDate' => $carbonDate,
            'formatDate' => $carbonDate->isoFormat('MMM D, Y'),
        ];
    }
}
