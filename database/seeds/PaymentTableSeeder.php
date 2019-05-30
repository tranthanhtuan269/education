<?php

use Illuminate\Database\Seeder;
use App\Payment;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ' THẺ NỘI ĐỊA: INTERNET BANKING',
            ' THẺ QUỐC TẾ: VISA / MASTER',
            ' THANH TOÁN NGÂN LƯỢNG',
            ' THANH TOÁN PAYPAL',
            ' CHUYỂN KHOẢN NGÂN HÀNG',
        ];

        foreach ($data as $key => $value) {
            $payment = new Payment; 
            $payment->name = $value; 
            $payment->status = 1; 
            $payment->save();
        }
    }
}
