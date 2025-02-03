<?php

namespace App\Charts;

use App\Models\User;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class SampleChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $today_users = User::whereDate('created_at', today())->count();
$yesterday_users = User::whereDate('created_at', today()->subDays(1))->count();
$users_2_days_ago = User::whereDate('created_at', today()->subDays(2))->count();

$chart = new SampleChart;
$chart->labels(['2 days ago', 'Yesterday', 'Today']);
$chart->dataset('My dataset', 'line', [$users_2_days_ago, $yesterday_users, $today_users]);
    }


}




// ...

