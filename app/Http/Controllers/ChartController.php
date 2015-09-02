<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;

class ChartController extends Controller
{
    /**
     * Show the specified photo comment.
     *
     * @param  int  $photoId
     * @param  int  $commentId
     * @return Response
     */
    public function getLineChartInfo()
    {
        $data = [
            'labels' => ["January", "February", "March", "April", "May", "June", "July"],
            'datasets' => [
                    [
                        'label' => "My First dataset",
                        'fillColor' => "rgba(220,220,220,0.2)",
                        'strokeColor' => "rgba(220,220,220,1)",
                        'pointColor' => "rgba(220,220,220,1)",
                        'pointStrokeColor' => "#fff",
                        'pointHighlightFill' => "#fff",
                        'pointHighlightStroke' => "rgba(220,220,220,1)",
                        'data' => [65, 59, 80, 81, 56, 55, 40]
                    ]
                ]
        ];
        return $data;
    }
}