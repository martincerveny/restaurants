<?php

namespace App\Console\Commands;

use App\Models\OpeningHours;
use App\Models\Restaurant;
use Illuminate\Console\Command;

/**
 * Class ImportData
 * @package App\Console\Commands
 */
class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports CSV file to database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = $this->ask('What is the name of the CSV file?') . ".csv";
        try {
            $csv = array_map('str_getcsv', file(base_path($fileName)));
        } catch (\Exception $e) {
            $this->error('Error: File not found');
            return;
        }

        if (count($csv[0]) > 2) {
            $this->parseSource1($csv);
        } else {
            $this->parseSource2($csv);
        }

        $this->info('CSV was successfully imported.');
    }

    /**
     * @param array $csv
     */
    private function parseSource1(array $csv)
    {
        foreach (array_slice($csv, 1) as $item) {
            $restaurant = Restaurant::create([
                'name' => $item[0],
                'tag' => $item[1],
                'cuisine' => $item[2],
                'price' => $item[6],
                'rating' => $item[7],
                'location' => $item[8],
                'description' => $item[9],
            ]);

            $daysAbbr = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
            $daysFull = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $translatedDays = str_replace($daysAbbr, $daysFull, $item[5]);
            $openingDays = explode(',', $translatedDays);

            foreach ($openingDays as $openingDay) {
                OpeningHours::create([
                    'restaurant_id' => $restaurant->id,
                    'day' => date('N', strtotime($openingDay)),
                    'open_time' => $item[3],
                    'close_time' => $item[4],
                ]);
            }
        }
    }

    /**
     * @param array $csv
     */
    private function parseSource2(array $csv)
    {
        foreach ($csv as $item) {
            $restaurant = Restaurant::create([
                'name' => $item[0],
            ]);

            $openingHours = explode('/', $item[1]);
            foreach ($openingHours as $openingHour) {
                $daysFull = [
                    'Mon' => 'Monday',
                    'Tue' => 'Tuesday',
                    'Wed' => 'Wednesday',
                    'Thu' => 'Thursday',
                    'Fri' => 'Friday',
                    'Sat' => 'Saturday',
                    'Sun' => 'Sunday'
                ];

                $firstNumberPos = $this->getFirstNumberOffset($openingHour);
                $daysRange = substr($openingHour, 0, $firstNumberPos);
                $timeRange = substr($openingHour, $firstNumberPos);
                $days = explode('-', $daysRange);
                $time = explode('-', $timeRange);
                $openTime = date("H:i", strtotime(trim($time[0])));
                $closeTime = date("H:i", strtotime(trim($time[1])));
                $from = $days[0];
                $firstMultipleDays = explode(',', $days[0]);

                if (count($days) > 1) {
                    $to = $days[1];
                    $secondMultipleDays = explode(',', $days[1]);
                }

                if (count($firstMultipleDays) > 1) {
                    $firstDay = $firstMultipleDays[0];
                    $secondDay = $firstMultipleDays[1];
                }

                if (isset($secondMultipleDays) && count($secondMultipleDays) > 1) {
                    $thirdDay = $secondMultipleDays[0];
                    $fourthDay = $secondMultipleDays[1];
                }

                if (isset($secondDay) && isset($firstDay)) {
                    $from = $secondDay;
                    $extraDay = $firstDay;
                }

                if (isset($thirdDay) && isset($fourthDay)) {
                    $to = $thirdDay;
                    $extraDay = $fourthDay;
                }

                if (isset($to)) {
                    $openingDays = array_values($this->getValuesFromTo(trim($from), trim($to), $daysFull));

                    if (isset($extraDay)) {
                        array_push($openingDays, $daysFull[trim($extraDay)]);
                    }
                } else {
                    $openingDays[] = $daysFull[trim($from)];
                }

                foreach ($openingDays as $openingDay) {
                    OpeningHours::create([
                        'restaurant_id' => $restaurant->id,
                        'day' => date('N', strtotime($openingDay)),
                        'open_time' => $openTime,
                        'close_time' => $closeTime,
                    ]);
                }

                unset($secondMultipleDays);
                unset($secondDay);
                unset($firstDay);
                unset($thirdDay);
                unset($fourthDay);
                unset($to);
                unset($extraDay);
                unset($openingDays);
            }
        }
    }

    /**
     * @param string $string
     * @return bool|int
     */
    private function getFirstNumberOffset(string $string)
    {
        preg_match('/^\D*(?=\d)/', $string, $m);
        return isset($m[0]) ? strlen($m[0]) : FALSE;
    }


    /**
     * @param $from
     * @param $to
     * @param $array
     * @return array
     */
    private function getValuesFromTo($from, $to, $array)
    {
        $keys = array_flip(array_keys($array));
        if (isset($keys[$from]) and isset($keys[$to])) {
            return array_slice($array, $keys[$from], $keys[$to] - $keys[$from] + 1);
        }
    }
}
