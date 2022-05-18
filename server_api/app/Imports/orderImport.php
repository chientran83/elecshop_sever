<?php

namespace App\Imports;

use App\Models\order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class orderImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         $newOrder = new order([
            'user_id' => 1,
            'product_id' => $row['product_id'],
            'coupon_id' => $row['coupon_id'],
            'price_total' => $row['price_total'],
            'deliveryInformation_id' => $row['deliveryinformation_id'],
            'quantity' => $row['quantity'],
            'method_payment' => $row['method_payment'],
            'color_id' => $row['color_id'],
            'tags_id' => $row['tags_id'],
            'memory_id' => $row['memory_id'],
            /* 'date' => date_format($date, 'Y-m-d'), */
            'date' => '2022-05-01',
            'status' => $row['status'],
            /* 'created_at' => date_format($created_at, 'Y-m-d H:i:s'),
            'updated_at' => date_format($updated_at, 'Y-m-d H:i:s') */
            'created_at' => '2022-04-27 08:16:16',
            'updated_at' => '2022-04-27 08:16:16'
        ]);

        return $newOrder;
        /* return new order([
            'user_id' => $user_id,
            'product_id' => $row['product_id'],
            'coupon_id' => $row['coupon_id'],
            'price_total' => $row['price_total'],
            'deliveryInformation_id' => $row['deliveryinformation_id'],
            'quantity' => $row['quantity'],
            'method_payment' => $row['method_payment'],
            'color_id' => $row['color_id'],
            'tags_id' => $row['tags_id'],
            'memory_id' => $row['memory_id'],
            // 'date' => date_format($date, 'Y-m-d'),
            'date' => '2022-05-01',
            'status' => $row['status'],
            // 'created_at' => date_format($created_at, 'Y-m-d H:i:s'),
            // 'updated_at' => date_format($updated_at, 'Y-m-d H:i:s')
            'created_at' => '2022-04-27 08:16:16',
            'updated_at' => '2022-04-27 08:16:16'
        ]); */
    }
}
