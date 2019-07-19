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

class GiftController extends Controller
{
    public function getGiveGift()
    {
        $courses = Course::where('status', 1)->get();
        return view('backends.gift.givegift', compact('courses'));
    }

    public function getGiftStudent()
    {
        // $data = User::inRandomOrder()->limit(10)->get();
        // dd($data);
        return view('backends.gift.givegift');
    }

    public function getGiftStudentAjax(Request $request)
    {
        $users = User::leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
                      ->select('users.name', 'user_roles.id')
                      ->where('user_roles.role_id', \Config::get('app.student'))
                      ->inRandomOrder()
                      ->limit($request->number)
                      ->get();;
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
                            if ($course) {
                                $video_count        = $course->video_count;
                                $first_video_index  = 1;
                                $first_video_id     = $course->units[0]->videos[0]->id;
                                $user_course_videos = [];

                                $course->student_count += 1;
                                $course->updated_at = $updated_at;
                                $course->save();

                                for ($i = 0; $i < $video_count; $i++) {
                                    array_push($user_course_videos, 0);
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

                                $course_link = url('course/'.$course->slug);
                                $course_name = $course->name;
                                $email = User::find($user_id)->email;
                                //Gui Email
                                dispatch(new SendEmailJob($course_link, $course_name, $email));
                                // $content_mail = [
                                //     'course_link'      => $course_link,
                                //     'course_name'      => $course_name,
                                // ];
                                // $email = ['trinhnk@tohsoft.com'];
                        
                                // \Mail::send('backends.emails.gift', $content_mail, function($message) use ($email) {
                                //     $message->from('nhansu@tohsoft.com', 'TOH-EDU');
                                //     $title = "[TOH-EDU] Qua tang...";
                                //     $message->to($email)->subject($title);
                                // });
                            }                         
                        }
                    }
                } else {
                        $user_id = UserRole::find($student)->user_id;
                        $course_id = $arr_new_gift_course_id[$random_keys];
                        $course = Course::find($course_id);

                        if ($course) {
                            $video_count = $course->video_count;
                            $first_video_index = 1;
                            $first_video_id = $course->units[0]->videos[0]->id;
                            $user_course_videos = [];

                            $course->student_count += 1;
                            $course->updated_at = $updated_at;
                            $course->save();

                            for ($i = 0; $i < $video_count; $i++) {
                                array_push($user_course_videos, 0);
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

                        $course_link = url('course/'.$course->slug);
                        $course_name = $course->name;
                        $email = User::find($user_id)->email;
                        //Gui Email
                        dispatch(new SendEmailJob($course_link, $course_name, $email));
                        // $content_mail = [
                        //     'course_link'      => $course_link,
                        //     'course_name'      => $course_name,
                        // ];
                
                        // $email = ['trinhnk@tohsoft.com'];
                
                        // \Mail::send('backends.emails.gift', $content_mail, function($message) use ($email) {
                        //     $message->from('nhansu@tohsoft.com', 'TOH-EDU');
                        //     $title = "[TOH-EDU] Qua tang...";
                        //     $message->to($email)->subject($title);
                        // });
                }
            }
        }
        
        Gift::insert($data);
        UserCourse::insert($data_user_courses);
        // Course::insert($data_student_count);
        return \Response::json(array('status' => '200', 'message' => 'Has been succeeded!'));
    }
}

class VideoJson
{
    public $videos, $learning, $learning_id;
}