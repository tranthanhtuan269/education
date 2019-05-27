<?php

use Illuminate\Database\Seeder;
use App\MailLog;
use App\UserMailLog;

class MailLogsTableSeeder extends Seeder
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
        for ($i = 1; $i < 13; $i++) {
            $mail_log = new MailLog;
            $mail_log->title = $data_demo[0].' '.$i;
            $mail_log->content = $data_demo[1];
            $mail_log->create_user_id = 1;
            $mail_log->update_user_id = 1;
            $mail_log->save();
            
            $data = \DB::table('user_roles')->limit(5)->get();
            $arr = [];
            foreach($data as $value) {
                $user_mail_log = new UserMailLog;
                $user_mail_log->user_role_id = $value->id;
                $user_mail_log->mail_log_id = $mail_log->id;
                $user_mail_log->sender_user_id =1;
                $user_mail_log->save();
            }
        }
    }
}
