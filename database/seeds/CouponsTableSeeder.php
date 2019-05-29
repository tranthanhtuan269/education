<?php

use Illuminate\Database\Seeder;
use App\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupon = new Coupon;
        $coupon->name = 'COUPON16';
        $coupon->value = '10';
        $coupon->expired = date("y-m-d");
        $coupon->status = 1;
        $coupon->save();


        $coupon = new Coupon;
        $coupon->name = 'COUPON277';
        $coupon->value = '10';
        $coupon->expired = date("y-m-d");
        $coupon->status = 1;
        $coupon->save();
    }
}
