<?php

namespace App\Traits\V1;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

trait DateManager
{
   /**
     * getStartOfMonth
     * @param \Carbon\Carbon $date
     * @return Carbon
     */
    private function getStartOfMonth(Carbon $date)
    {
        try {
            return Carbon::create($date->year, $date->month, 1);
        }catch(Exception $e) {
            Log::error('DateManagement::getStartOfMonth', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getCurrentYearStartDate
     * @param \Carbon\Carbon $date
     * @return Carbon
     */
    private function getCurrentYearStartDate(Carbon $date)
    {
        try {
            return Carbon::create($date->year, 1, 1)->startOfDay(); // January 1st
        }catch(Exception $e) {
            Log::error('DateManagement::getCurrentYearStartDate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getCurrentYearEndDate
     * @param \Carbon\Carbon $date
     * @return Carbon
     */
    private function getCurrentYearEndDate(Carbon $date)
    {
        try {
            return Carbon::create($date->year, 12, 31)->endOfDay(); // December 31st
        }catch(Exception $e) {
            Log::error('DateManagement::getCurrentYearEndDate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getCurrentQuarterStartDate
     * @param \Carbon\Carbon $date
     * @return Carbon|null
     */
    private function getCurrentQuarterStartDate(Carbon $date)
    {
        try {
            $month = $date->month;

            if ($month <= 3) {
                return Carbon::create($date->year, 1, 1);  // Q1 starts on January 1st
            } elseif ($month <= 6) {
                return Carbon::create($date->year, 4, 1);  // Q2 starts on April 1st
            } elseif ($month <= 9) {
                return Carbon::create($date->year, 7, 1);  // Q3 starts on July 1st
            } else {
                return Carbon::create($date->year, 10, 1); // Q4 starts on October 1st
            }
        }catch(Exception $e) {
            Log::error('DateManagement::getCurrentQuarterStartDate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getCurrentQuarterEndDate
     * @param \Carbon\Carbon $date
     * @return \Carbon\Carbon|null
     */
    private function getCurrentQuarterEndDate(Carbon $date)
    {
        try {
            $month = $date->month;

            if ($month <= 3) {
                return Carbon::create($date->year, 3, 31);  // Q1 ends on March 31st
            } elseif ($month <= 6) {
                return Carbon::create($date->year, 6, 30);  // Q2 ends on June 30th
            } elseif ($month <= 9) {
                return Carbon::create($date->year, 9, 30);  // Q3 ends on September 30th
            } else {
                return Carbon::create($date->year, 12, 31); // Q4 ends on December 31st
            }
        }catch(Exception $e) {
            Log::error('DateManagement::getCurrentQuarterEndDate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
