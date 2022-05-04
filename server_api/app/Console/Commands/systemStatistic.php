<?php

namespace App\Console\Commands;

use App\Models\statistic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class systemStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $statistic;
    public function __construct(statistic $statistic)
    {
        parent::__construct();
        $this->statistic= $statistic;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $timeNow = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $orders = DB::table('tbl_orders')->where('date',$timeNow)->get();
        $StaticDataArr=[];

        //save quantity product purchased
        $products = DB::table('tbl_product')->where('created_at','>',date('Y-m-d H:i:s', strtotime($timeNow)))->get();
        $StaticDataArr['quantityPurchased'] = 0;
        foreach ($products as $key => $product) {
            $StaticDataArr['quantityPurchased'] += $product->quantity;
        }
       
        //save new user
        $users = DB::table('users')->where('created_at','>',date('Y-m-d H:i:s', strtotime($timeNow)))->get();
        $StaticDataArr['newUser'] = $users->count();
        // save profit
        $profit = 0;
        $StaticDataArr['paymentLater'] = 0;
        $StaticDataArr['paymentOnline'] = 0;
        foreach ($orders as $key => $order) {
            $product = DB::table('tbl_product')->where('id',$order->product_id)->first();
            $profit += $order->price_total - ($product->origin_price * $order->quantity);

            if($order->method_payment == 'postpaid'){
                $StaticDataArr['paymentLater'] += 1;
            }else{
                $StaticDataArr['paymentOnline'] += 1;

            }
        }
        $statistic = $this->statistic->where('date',$timeNow)->first();
        if(empty($statistic)){
            $StaticDataArr['date'] = $timeNow;
            $StaticDataArr['profit'] = $profit;
            $StaticDataArr['quantitySold'] = $orders->count();
            $this->statistic->create($StaticDataArr);
        }
        return 1;
    }
}
