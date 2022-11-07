<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\User;
use Backpack\CRUD\app\Library\Widget;

// use ConsoleTVs\Charts\Classes\Echarts\Chart;
// use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
// use ConsoleTVs\Charts\Classes\Highcharts\Chart;
// use ConsoleTVs\Charts\Classes\C3\Chart;
// use ConsoleTVs\Charts\Classes\Frappe\Chart;

/**
 * Class WeeklyUsersChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WeeklyUsersChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels([




            'Today',
        ]);

        Widget::add([
            'type'       => 'chart',
            'controller' => \App\Http\Controllers\Admin\Charts\WeeklyUsersChartController::class,

            // OPTIONALS

            'class'   => 'card mb-2',
            'wrapper' => ['class'=> 'col-md-6'] ,
            'content' => [
                 'header' => 'New Users',
                 'body'   => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>',
            ],
        ]);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/weekly-users'));

        // OPTIONAL
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);



    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $users_created_today = \App\Models\User::whereDate('created_at', today())->count();

        $this->chart->dataset('Users Created', 'bar', [
                    $users_created_today,
                ])
            ->color('rgba(205, 32, 31, 1)')
            ->backgroundColor('rgba(205, 32, 31, 0.4)');
    }
}
