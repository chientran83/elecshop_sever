<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\permission;
use App\Models\resource;
use App\Models\role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* \App\Models\User::factory(10)->create(); */
        /* \App\Models\product::factory(16)->create();
        \App\Models\category::factory(6)->create();
        \App\Models\slider::factory(6)->create(); */

        $checkExistAdminAccount = User::where('email','admin@gmail.com')->first();
        if(empty($checkExistAdminAccount)){
            User::create([
                'id' =>1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make(123456),
                'remember_token' => Str::random(10),
                'image_path' => '/storage/product/1/MKHXeqsLqVWsu5WSNFjz.jpg',
                'phoneNumber' => 888888888,
                'location' => "QN-VN"
            ]);

            //order
            resource::create([
                'id' => 1,
                'alias' => 'order'
            ]);

            permission::create([
                'allow' => 'indexForAdmin',
                'role_id' => 0,
                'resource_id' => 1
            ]);
            permission::create([
                'allow' => 'changeStatusOrder',
                'role_id' => 0,
                'resource_id' => 1
            ]);
            permission::create([
                'allow' => 'rejectOrder',
                'role_id' => 0,
                'resource_id' => 1
            ]);
            permission::create([
                'allow' => 'acceptOrder',
                'role_id' => 0,
                'resource_id' => 1
            ]);
            //statistic
            resource::create([
                'id' => 2,
                'alias' => 'statistic'
            ]);
            permission::create([
                'allow' => 'filterBySelect',
                'role_id' => 0,
                'resource_id' => 2
            ]);
            permission::create([
                'allow' => 'filterByDate',
                'role_id' => 0,
                'resource_id' => 2
            ]);
            permission::create([
                'allow' => 'profitData',
                'role_id' => 0,
                'resource_id' => 2
            ]);
            //category
            resource::create([
                'id' => 3,
                'alias' => 'category'
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 3
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 3
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 0,
                'resource_id' => 3
            ]);
            //product
            resource::create([
                'id' => 4,
                'alias' => 'product'
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 4
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 4
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 0,
                'resource_id' => 4
            ]);
            //slider
            resource::create([
                'id' => 5,
                'alias' => 'slider'
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 5
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 5
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 0,
                'resource_id' => 5
            ]);
            //user
            resource::create([
                'id' => 6,
                'alias' => 'user'
            ]);
            permission::create([
                'allow' => 'index',
                'role_id' => 0,
                'resource_id' => 6
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 6
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 0,
                'resource_id' => 6
            ]);
            //role
            resource::create([
                'id' => 7,
                'alias' => 'role'
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 7
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 7
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 0,
                'resource_id' => 7
            ]);
            //permission
            resource::create([
                'id' => 8,
                'alias' => 'role'
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 8
            ]);
            //resource
            resource::create([
                'id' => 9,
                'alias' => 'resource'
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 9
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 9
            ]);
            permission::create([
                'allow' => 'delete',
                'role_id' => 0,
                'resource_id' => 9
            ]);
            //coupon
            resource::create([
                'id' => 10,
                'alias' => 'coupon'
            ]);
            permission::create([
                'allow' => 'index',
                'role_id' => 0,
                'resource_id' => 10
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 0,
                'resource_id' => 10
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 0,
                'resource_id' => 10
            ]);
            permission::create([
                'allow' => 'delete',
                'role_id' => 0,
                'resource_id' => 10
            ]);


            //assign permission for role 
            

            role::create([
                'id' => 1,
                'name' => 'admin',
                'desc' => 'all permission',
                'status' => 1
            ]);

            DB::table('tbl_user_role')->insert(['user_id' => 1,'role_id' => 1]);

            permission::create([
                'allow' => 'indexForAdmin',
                'role_id' => 1,
                'resource_id' => 1
            ]);
            permission::create([
                'allow' => 'changeStatusOrder',
                'role_id' => 1,
                'resource_id' => 1
            ]);
            permission::create([
                'allow' => 'rejectOrder',
                'role_id' => 1,
                'resource_id' => 1
            ]);
            permission::create([
                'allow' => 'acceptOrder',
                'role_id' => 1,
                'resource_id' => 1
            ]);
            //statistic
            permission::create([
                'allow' => 'filterBySelect',
                'role_id' => 1,
                'resource_id' => 2
            ]);
            permission::create([
                'allow' => 'filterByDate',
                'role_id' => 1,
                'resource_id' => 2
            ]);
            permission::create([
                'allow' => 'profitData',
                'role_id' => 1,
                'resource_id' => 2
            ]);
            //category
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 3
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 3
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 1,
                'resource_id' => 3
            ]);
            //product
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 4
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 4
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 1,
                'resource_id' => 4
            ]);
            //slider
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 5
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 5
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 1,
                'resource_id' => 5
            ]);
            //user
            permission::create([
                'allow' => 'index',
                'role_id' => 1,
                'resource_id' => 6
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 6
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 1,
                'resource_id' => 6
            ]);
            //role
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 7
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 7
            ]);
            permission::create([
                'allow' => 'destroy',
                'role_id' => 1,
                'resource_id' => 7
            ]);
            //permission
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 8
            ]);
            //resource
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 9
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 9
            ]);
            permission::create([
                'allow' => 'delete',
                'role_id' => 1,
                'resource_id' => 9
            ]);
            //coupon
            permission::create([
                'allow' => 'index',
                'role_id' => 1,
                'resource_id' => 10
            ]);
            permission::create([
                'allow' => 'store',
                'role_id' => 1,
                'resource_id' => 10
            ]);
            permission::create([
                'allow' => 'update',
                'role_id' => 1,
                'resource_id' => 10
            ]);
            permission::create([
                'allow' => 'delete',
                'role_id' => 1,
                'resource_id' => 10
            ]);

        }
    }
}
