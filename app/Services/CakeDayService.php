<?php

namespace App\Services;

use App\Models\Developer;
use App\Models\Holiday;
use App\Models\Upload;
use Carbon\Carbon;

class CakeDayService
{

    // Define holidays
    protected $holidays = [];

    /**
     * Calculate Cake Days for developers.
     *
     * @param array $developers
     * @return array
     */
    public function calculateCakeDays($upload_id)
    {

        $nextWorkingDaysForCake = [];
        $this->holidays = $this->getUkHolidays();

        if (!is_null($upload_id)) {
            $developers = Developer::where('upload_id', $upload_id)->orderBy('next_working_day', 'desc')->get();
        } else if(is_null($upload_id)){
           $active_uploads = Upload::orderByDesc('created_at')->first();

            $developers = Developer::where('upload_id', $active_uploads->uuid)->orderBy('next_working_day', 'desc')->get();
            // exit(json_encode($developers));
        }
        else {
            $active_uploads = Upload::where('status', 1)->first();

             $developers = Developer::where('upload_id', $active_uploads->uuid)->orderBy('next_working_day', 'desc')->get();
         }


        $cakeDays = [];
        $scheduledCakes = [];
        $groupedCakeDays = [];

        // Step 1: Calculate initial Cake Days for each developer
        foreach ($developers as $developer) {

            $nextWorkingDaysForCake[] = $developer['next_working_day'];


            $nextWorkingDay = $developer['next_working_day'];
            // $groupedCakeDays[$nextWorkingDay][] = $developer['name'];

            $groupedCakeDays[$nextWorkingDay][] = $developer['name'];
        }

        // Remove duplicates
        $nextWorkingDaysForCake = array_unique($nextWorkingDaysForCake);
        // Re-index the array (optional)
        $nextWorkingDays = array_values($nextWorkingDaysForCake);

        // Step 2: Sort the nextWorkingDays chronologically
        sort($nextWorkingDays);

        $previousCakeDay = null;
        $finalCakeDays = [];
        $developer_info_cake = [];

        foreach ($nextWorkingDays as $day) {
            if (!isset($groupedCakeDays[$day])) {
                continue; // Skip days with no developers
            }

            // Rule 1: Merge coinciding Cake Days
            $developers = $groupedCakeDays[$day];
            $type = (count($developers) > 1) ? 'large' : 'small';

            // Rule 2: Check for consecutive Cake Days
            if ($previousCakeDay && $this->isConsecutiveDay($previousCakeDay, $day)) {
                // Merge into a large cake on the second day
                $finalCakeDays[$day] = [
                    'cake_day' => $day,
                    'type' => 'large',
                    'developers' => array_merge(
                        $finalCakeDays[$previousCakeDay]['developers'],
                        $developers
                    ),
                ];
                unset($finalCakeDays[$previousCakeDay]); // Remove the previous day's cake
            } else {
                // Add a small or large cake for the current day
                $finalCakeDays[$day] = [
                    'cake_day' => $day,
                    'type' => $type,
                    'developers' => $developers,
                ];
            }
            $previousCakeDay = $day; // Track the previous Cake Day
        }


        return  array_values($finalCakeDays);
    }








    // Helper function to check if two dates are consecutive
    public function isConsecutiveDay($date1, $date2)
    {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);
        return $date1->modify('+1 day')->format('Y-m-d') === $date2->format('Y-m-d');
    }






    public function getNextWorkingDay($developer, $date_of_birth, $date, $holidays)
    {
        $cakedayInfo = [
            'developer' => $developer,
            'date_of_birth' => $date_of_birth,
            'off_day' => Carbon::parse($date)->format('Y-m-d'),
            'birthday' => Carbon::parse($date)->format('Y-m-d'),
            'isWeekend' => false,
            'isHoliday' => false,
            'log' => ''
        ];

        // $birthdayDayMonth =  Carbon::parse($date)->format('Y-m-d'); // Extract MM-DD from the date
        $birthdayDayMonth = $date;


        // print_r($holidays);exit;
        // exit(json_encode($holidays));

        if (!$date->isWeekend()) {
            $date->addDay();
        }


        while ($date->isWeekend() || in_array($birthdayDayMonth, $holidays)) {

            $cakedayInfo['isWeekend'] = ($date->isWeekend()) ?  true : false;
            $cakedayInfo['isHoliday'] = (in_array($birthdayDayMonth, $holidays)) ?  true : false;

            if ($date->isWeekend()) {
                $date->addDay();
            }

            $date->addDay();
        }

        $cakeDay = $date->toDateString();
        // $cakeDay = null;

        $cakedayInfo['cakeDay'] = $date->toDateString();
        $cakedayInfo['next_working_day'] = $date->toDateString();


        // contruct a log journey for calculationa
        $log = "{$developer}'s birthday is {$birthdayDayMonth} which " .
            ($cakedayInfo['isWeekend'] ? "is" : "is not") . " a weekend and also " .
            ($cakedayInfo['isHoliday'] ? "is" : "is not") . " a holiday. " .
            "Therefore, the cake day is {$cakeDay}. \n ";

        // $this->logTheRuleApplied($log) ;

        // $cakedayInfo['log'] = $log;

        //  exit(json_encode($cakedayInfo));

        return $cakedayInfo;
    }

    public function getUkHolidays($year = '2025')
    {
        $db_holidays = Holiday::pluck('date')->toArray();

        $holidays = array_map(function ($date) use ($year) {
            return  Carbon::parse($date)->format("{$year}-m-d");
        }, $db_holidays);

        // $this->holidays = $holidays;

        return $holidays;
    }
}
