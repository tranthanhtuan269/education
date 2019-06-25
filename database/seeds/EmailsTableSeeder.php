<?php

use Illuminate\Database\Seeder;
use App\Email;
use App\UserEmail;

class EmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_demo = ['Thông báo khuyến mãi', '<p>Your team has valuable knowledge buried in outdated docs, emails, chat messages—and tucked away with subject matter experts. Stack Overflow gives your team a private, secure home for their questions and answers.
            With our Private Q&A, reduce siloed knowledge, free up resources, and onboard faster by building your own private community with a centralized source of searchable answers.</p>'];
        for ($i = 1; $i < 55; $i++) {
            $email = new Email;
            $email->title = $data_demo[0].' '.$i;
            $email->content = $data_demo[1];
            $email->create_user_id = 1;
            $email->update_user_id = 1;
            $email->save();
            
            $data = \DB::table('user_roles')->limit(5)->get();
            $arr = [];
            foreach($data as $value) {
                $user_email = new UserEmail;
                $user_email->user_id = $value->id;
                $user_email->email_id = $email->id;
                $user_email->sender_user_id =1;
                $user_email->save();
            }
        }
    }
}
