<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BirthDayCakeController extends Controller
{
    public function home()
    {

        $birthdays = [
            [
                "cake_day" => "2025-01-03",
                "type" => "small",
                "developers" => ["Margaret"]
            ],
            [
                "cake_day" => "2025-01-07",
                "type" => "large",
                "developers" => ["Marthin", "Martha"]
            ],
            [
                "cake_day" => "2025-01-21",
                "type" => "small",
                "developers" => ["Freya"]
            ],
            [
                "cake_day" => "2025-06-09",
                "type" => "large",
                "developers" => ["Kwabena", "King", "Sylvia"]
            ],
            [
                "cake_day" => "2025-06-30",
                "type" => "small",
                "developers" => ["Dorothy"]
            ],
            [
                "cake_day" => "2025-07-08",
                "type" => "small",
                "developers" => ["Astrid"]
            ],
            [
                "cake_day" => "2025-07-16",
                "type" => "large",
                "developers" => ["Patricia", "Giselle"]
            ],
            [
                "cake_day" => "2025-07-24",
                "type" => "large",
                "developers" => ["Clementine", "Roberta", "Edith"]
            ],
            [
                "cake_day" => "2025-09-23",
                "type" => "small",
                "developers" => ["Luna"]
            ],
            [
                "cake_day" => "2025-12-24",
                "type" => "large",
                "developers" => ["Doreen", "Mabel"]
            ],
        ];
        // return $birthdays;
        return view('welcome', [
            'birthdays' => $birthdays
        ]);

    }
}
