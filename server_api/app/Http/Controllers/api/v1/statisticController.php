<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use App\Models\statistic;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class statisticController extends Controller
{
    public $statistic;
    public function __construct(statistic $statistic){
        $this->statistic = $statistic;
    }
    public function profitData(){
        $timeNow = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        /* this week's profit compare with last week */
        $startOfWeek = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->toDateString();
        $profitOfWeek = $this->getProfit($startOfWeek,$timeNow);
        $startOfLastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->startOfWeek()->toDateString();
        $endOfLastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->endOfWeek()->toDateString();
        $profitLastWeek = $this->getProfit($startOfLastWeek,$endOfLastWeek);
        $dataOfWeek = array(
            'profit' => $profitOfWeek,
            'profitOfLassWeek' => $profitLastWeek,
            'evaluation' => $profitOfWeek < $profitLastWeek ? "decrease" : "increase",
            'percent' => round(($profitOfWeek - $profitLastWeek) / $profitLastWeek * 100,1)
        );

        /* this month's profit compare with last month */
        $startOfMonth = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $profitOfMonth = $this->getProfit($startOfMonth,$timeNow);
        $startOfLastMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $EndOfLastMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $profitLastMonth = $this->getProfit($startOfLastMonth,$EndOfLastMonth);
        $dataOfMonth = array(
            'profit' => $profitOfMonth,
            'profitOfLassMonth' => $profitLastMonth,
            'evaluation' => $profitOfMonth < $profitLastMonth ? "decrease" : "increase",
            'percent' => round(($profitOfMonth - $profitLastMonth) / $profitLastMonth * 100,1)
        );

        /* this year's profit compare with last year */
        $startOfYear = Carbon::now('Asia/Ho_Chi_Minh')->startOfYear()->toDateString();
        $profitOfYear = $this->getProfit($startOfYear,$timeNow);
        $startOfLastYear = Carbon::now('Asia/Ho_Chi_Minh')->subYear()->startOfYear()->toDateString();
        $EndOfLastYear = Carbon::now('Asia/Ho_Chi_Minh')->subYear()->endOfYear()->toDateString();
        $profitLastYear = $this->getProfit($startOfLastYear,$EndOfLastYear);
        $dataOfYear = array(
            'profit' => $profitOfYear,
            'profitOfLassYear' => $profitLastYear,
            'evaluation' => $profitOfYear < $profitLastYear ? "decrease" : "increase",
            'percent' => round(($profitOfYear - $profitLastYear) / $profitLastYear * 100,1)
        );

        $data = array(
            'profitOfWeek' =>  $dataOfWeek,
            'profitOfMonth' =>  $dataOfMonth,
            'profitOfYear' =>  $dataOfYear
        );
        return $data;
    }

    public function getProfit($fromDate,$toDate){
        $statistics = DB::table('tbl_statistics')->whereBetween('date',[$fromDate,$toDate])->get();
        $profit = 0;
        if($statistics){
            foreach ($statistics as $key => $statistic) {
                $profit += $statistic->profit;
            }
        }
        return $profit;
    }
    
    public function filterBySelect(Request $request){
        $timeNow = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $sub7day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub14day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(14)->toDateString();
        $subMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->toDateString();
        $sub6Month = Carbon::now('Asia/Ho_Chi_Minh')->subMonths(6)->toDateString();
        $subYear = Carbon::now('Asia/Ho_Chi_Minh')->subYear()->toDateString();

        if($request->value == "7Ago"){
            $statistics = DB::table('tbl_statistics')->whereBetween('date',[$sub7day,$timeNow])->get();
        }elseif($request->value == "14Ago"){
            $statistics = DB::table('tbl_statistics')->whereBetween('date',[$sub14day,$timeNow])->get();
        }elseif($request->value == "monthAgo"){
            $statistics = DB::table('tbl_statistics')->whereBetween('date',[$subMonth,$timeNow])->get();
        }elseif($request->value == "6MonthAgo"){
            $statistics = DB::table('tbl_statistics')->whereBetween('date',[$sub6Month,$timeNow])->get();
        }elseif($request->value == "yearAgo"){
            $statistics = DB::table('tbl_statistics')->whereBetween('date',[$subYear,$timeNow])->get();
        }else{
            return response()->json([
                'code' => 401,
                'message' => 'request undefined !'
            ],401);
        }
        
        $chartData = $this->getStatisticData($statistics);
        return response()->json($chartData);
    }
    public function filterByDate(Request $request){
        $fromDate =  $request->fromDate;
        $toDate = $request->toDate;

        $statistics = DB::table('tbl_statistics')->whereBetween('date',[$fromDate,$toDate])->get();
        if($statistics){
            $chartData = $this->getStatisticData($statistics);
            return response()->json($chartData);
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'value undefined !'
            ],404);
        }
    }
    public function getStatisticData($statistics){
        $chartData = [];
        $dataLineChart = [];
        $dataDonutChart = [];
        $paymentOnline = 0;
        $paymentLater = 0;
        foreach ($statistics as $key => $statistic) {
            $dataLineChart['profit']['chartLabel'][] = $statistic->date;
            $dataLineChart['profit']['chartData'][] = $statistic->profit;
            
            $dataLineChart['quantitySoldAndPurchased']['chartLabel'][] = $statistic->date;
            $dataLineChart['quantitySold']['chartData'][] = $statistic->quantitySold;
            $dataLineChart['quantityPurchased']['chartData'][] = $statistic->quantityPurchased;
            
            $dataLineChart['newUser']['chartLabel'][] = $statistic->date;
            $dataLineChart['newUser']['chartData'][] = $statistic->newUser;
          
            $paymentOnline += $statistic->paymentOnline;
            $paymentLater += $statistic->paymentLater;
        }
        $chartData['dataLineChart'] = $dataLineChart;
        $dataDonutChart['payment']['chartLabel'][] = 'payment Online';
        $dataDonutChart['payment']['chartLabel'][] = 'payment Later';
        $dataDonutChart['payment']['chartData'][] = $paymentOnline;
        $dataDonutChart['payment']['chartData'][] = $paymentLater;
        $chartData['dataDonutChart'] = $dataDonutChart;
        return $chartData;
    }
}
