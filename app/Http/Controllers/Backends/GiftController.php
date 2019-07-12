<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;

use App\Course;
use App\User;
use App\Gift;
use App\UserCourse;

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
        $created_at = $updated_at = date('Y-m-d H:i:s');

        foreach ($arr_student_id as $student) {
            $arr_new_gift_course_id = $arr_gift_course_id;
            $arr_student_course_id = UserCourse::where('user_role_id', $student)->pluck('course_id');
            
            if (count($arr_student_course_id) > 0) {
                $arr_new_gift_course_id = array_diff( $arr_gift_course_id, $arr_student_course_id );
            }  

            if (count($arr_new_gift_course_id) > 0) {
                if (count($arr_new_gift_course_id) < 3) {
                    $rand = rand(1, count($arr_new_gift_course_id));
                } else {
                    $rand = rand(1, 3);
                }
    
                $random_keys = array_rand($arr_new_gift_course_id, $rand);

                if (is_array($random_keys)) {
                    for ($i=0; $i < $rand ; $i++) {
                        if ( isset($arr_new_gift_course_id[$random_keys[$i]]) ) {
                            $data[] = [
                                'user_role_id' => $student,
                                'course_id'    => $arr_new_gift_course_id[$random_keys[$i]],
                                'created_at'   => $created_at,
                                'updated_at'   => $updated_at,
                            ];
                        }
                    }
                } else {
                        $data[] = [
                            'user_role_id' => $student,
                            'course_id'    => $arr_new_gift_course_id[0],
                            'created_at'   => $created_at,
                            'updated_at'   => $updated_at,
                        ];
                }
            }
        }
        
        Gift::insert($data);
        return \Response::json(array('status' => '200', 'message' => 'Has been succeeded!'));
    }
}