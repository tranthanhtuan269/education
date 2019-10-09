<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;

use App\Course;
use App\User;
use App\Gift;
use App\UserCourse;
use App\UserRole;
// use App\Jobs\SendGiftEmail;
use App\Jobs\SendEmailJob;
use App\Email;
use Config;

class GiftController extends Controller
{
    public function getGiveGift()
    {
        $courses = Course::listCourseSpecial(2)->get();
        return view('backends.gift.givegift', compact('courses'));
    }

    public function getGiftStudent()
    {
        return view('backends.gift.givegift');
    }

    public function getGiftStudentAjax(Request $request)
    {
        $users = User::leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
                      ->select('users.email', 'user_roles.id')
                      ->where('user_roles.role_id', \Config::get('app.student'))
                      ->where('users.status', 1)
                      ->inRandomOrder()
                      ->limit($request->number)
                      ->get();
        return datatables()->collection($users)
            ->addColumn('id', function ($user) {
                return $user->id;
            })
            ->make(true);
    }

    public function handlingGiftAjax(Request $request){    
        $arr_gift_course_id = $request->course_id;
        $arr_student_id = $request->student_id;
        $data = [];
        $data_user_courses = [];
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $data_student_count = [];

        foreach ($arr_student_id as $student) {
            $arr_new_gift_course_id = $arr_gift_course_id;
            $arr_student_course_id = UserCourse::where('user_role_id', $student)->pluck('course_id')->toArray();
            
            if (count($arr_student_course_id) > 0) {
                $arr_new_gift_course_id = array_diff( $arr_gift_course_id, $arr_student_course_id );
            }  

            if (count($arr_new_gift_course_id) > 0) {
                if (count($arr_new_gift_course_id) < 3) {
                    $rand = rand(1, count($arr_new_gift_course_id));
                } else {
                    $rand = rand(1, 3);
                }
                // echo '<pre>';
                // print_r($arr_new_gift_course_id);
                $random_keys = array_rand($arr_new_gift_course_id, $rand);

                if (is_array($random_keys)) {
                    for ($i=0; $i < $rand ; $i++) {
                        if ( isset($arr_new_gift_course_id[$random_keys[$i]]) ) {
                            $user_id = UserRole::find($student)->user_id;
                            // echo User::find($user_id)->email;die;
                            $course_id = $arr_new_gift_course_id[$random_keys[$i]];
                            $data[] = [
                                'user_role_id' => $student,
                                'course_id'    => $course_id,
                                'created_at'   => $created_at,
                                'updated_at'   => $updated_at,
                            ];

                            $course = Course::find($course_id);

                            //Không tặng khóa học cho chính tác giả
                            $products = [];
                            $arr_products = \App\User::find($user_id)->products;
                            $arr_products = str_replace('[','',$arr_products);
                            $arr_products = str_replace(']','',$arr_products);
                            $arr_products = explode(",",$arr_products);
                            $check = array_search($course->id, $arr_products);
                            if ($check){
                                continue;
                            }
                            // End 

                            if ($course) {
                                $video_count        = $course->video_count;
                                $first_video_index  = 1;
                                if( isset($course->units[0]->videos[0]->id) ){
                                    $first_video_id     = $course->units[0]->videos[0]->id;
                                }else{
                                    continue;
                                }
                                $user_course_videos = [];
                                $units = $course->units;

                                $course->student_count += 1;
                                $course->updated_at = $updated_at;
                                $course->save();

                                foreach ($units as $key => $unit) {
                                    if($unit->video_count > 0){
                                        $unit_arr = [];
                                        for ($k=0; $k < $unit->video_count; $k++) { 
                                            array_push($unit_arr, 0);                                    
                                        }
                                        array_push($user_course_videos, $unit_arr);
                                    }
                                }

                                $videoJson = new VideoJson;
                                $videoJson->videos = $user_course_videos;
                                $videoJson->learning = 1;
                                $videoJson->learning_id = $first_video_id;
                                $videoJson = json_encode($videoJson);
                                $data_user_courses[] = [
                                    'user_role_id' => $student,
                                    'course_id'    => $course_id,
                                    'videos'       => $videoJson,
                                    'created_at'   => $created_at,
                                    'updated_at'   => $updated_at,
                                    'status'       => 1,
                                ];

                                $course_link = url('course/'.$course->id.'/'.$course->slug);
                                $course_name = $course->name;
                                $current_user= User::find($user_id);
                                $email = $current_user->email;

                                // add to bought of user 
                                $bought = [];
                                if (strlen($current_user->bought) > 0) {
                                    $bought = \json_decode($current_user->bought);
                                }
                                $bought[] = $course->id;
                                $current_user->bought = \json_encode($bought);
                                $current_user->save();

                                //Them thong bao he thong
                                $user_email  = new \App\UserEmail;
                                $user_email->user_id = $current_user->id;
                                $user_email->email_id = 1;
                                $user_email->sender_user_id = 333;
                                $user_email->content = "Chúc mừng bạn vừa nhận được một khóa học miễn phí từ Courdemy. Click vào <a href='".$course_link."'> đây </a> để xem chi tiết khóa học.";
                                $user_email->title = "Chúc mừng bạn vừa nhận được một khóa học miễn phí từ Courdemy";
                                $user_email->save();

                                //Gui Email
                                dispatch(new SendEmailJob($course_link, $course_name, $email));
                            }                         
                        }
                    }
                } else {
                        $user_id = UserRole::find($student)->user_id;
                        $course_id = $arr_new_gift_course_id[$random_keys];
                        $course = Course::find($course_id);

                        //Không tặng khóa học cho chính tác giả
                        $products = [];
                        $arr_products = \App\User::find($user_id)->products;
                        $arr_products = str_replace('[','',$arr_products);
                        $arr_products = str_replace(']','',$arr_products);
                        $arr_products = explode(",",$arr_products);
                        $check = array_search($course->id, $arr_products);
                        if ($check){
                            continue;
                        }
                        // End 

                        if ($course) {
                            $video_count = $course->video_count;
                            $first_video_index = 1;
                            if( isset($course->units[0]->videos[0]->id) ){
                                $first_video_id = $course->units[0]->videos[0]->id;
                            }else{
                                continue;
                            }
                            $user_course_videos = [];
                            $units = $course->units;

                            $course->student_count += 1;
                            $course->updated_at = $updated_at;
                            $course->save();

                            foreach ($units as $key => $unit) {
                                if($unit->video_count > 0){
                                    $unit_arr = [];
                                    for ($k=0; $k < $unit->video_count; $k++) { 
                                        array_push($unit_arr, 0);                                    
                                    }
                                    array_push($user_course_videos, $unit_arr);
                                }
                            }

                            $videoJson = new VideoJson;
                            $videoJson->videos = $user_course_videos;
                            $videoJson->learning = 1;
                            $videoJson->learning_id = $first_video_id;
                            $videoJson = json_encode($videoJson);
                            $data_user_courses[] = [
                                'user_role_id' => $student,
                                'course_id'    => $course_id,
                                'videos'       => $videoJson,
                                'created_at'   => $created_at,
                                'updated_at'   => $updated_at,
                                'status'       => 1,
                            ];
                        }

                        $data[] = [
                            'user_role_id' => $student,
                            'course_id'    => $course_id,
                            'created_at'   => $created_at,
                            'updated_at'   => $updated_at,
                        ];

                        $course_link = url('course/'.$course->id.'/'.$course->slug);
                        $course_name = $course->name;
                        $current_user= User::find($user_id);
                        $email = $current_user->email;

                        //Them thong bao he thong
                        $user_email  = new \App\UserEmail;
                        $user_email->user_id = $current_user->id;
                        $user_email->email_id = 1;
                        $user_email->sender_user_id = 333;
                        $user_email->content = "Chúc mừng bạn vừa nhận được một khóa học miễn phí từ Courdemy. Click vào <a href='".$course_link."'> đây </a> để xem chi tiết khóa học.";
                        $user_email->title = "Chúc mừng bạn vừa nhận được một khóa học miễn phí từ Courdemy";
                        $user_email->save();

                        // add to bought of user 
                        $bought = [];
                        if (strlen($current_user->bought) > 0) {
                            $bought = \json_decode($current_user->bought);
                        }
                        $bought[] = $course->id;
                        $current_user->bought = \json_encode($bought);
                        $current_user->save();

                        //Gui Email
                        dispatch(new SendEmailJob($course_link, $course_name, $email));
                }
            }
        }
        
        Gift::insert($data);
        UserCourse::insert($data_user_courses);
        // Course::insert($data_student_count);
        return \Response::json(array('status' => '200', 'message' => 'Tặng khóa học thành công!'));
    }
}

class VideoJson
{
    public $videos, $learning, $learning_id;
}