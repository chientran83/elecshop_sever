<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\statistic;
use Illuminate\Http\Request;

class statisticController extends Controller
{
    public $statistic;
    public function __construct(statistic $statistic){
        $this->statistic = $statistic;
    }

    
}
