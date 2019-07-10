<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Course;
use App\UserCourse;


class GiftController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        if ($request->image != '') {
            $img_file = $request->image;
            list($type, $img_file) = explode(';', $img_file);
            list(, $img_file) = explode(',', $img_file);
            $img_file = base64_decode($img_file);
            $file_name = time() . '.png';
            file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
            $img_link = $file_name;
        }

        $item = new Course;
        $item->name                 = $request->name;
        $item->image                = $img_link;
        $item->short_description    = $request->short_description;
        $item->description          = $request->description;
        $item->will_learn           = $request->will_learn;
        $item->requirement          = $request->requirement;
        $item->price                = $request->price;
        $item->real_price           = $request->price;
        $item->level                = $request->level;
        $item->approx_time          = $request->approx_time;
        $item->category_id          = $request->category;
        $item->created_at           = date('Y-m-d H:i:s');
        $item->updated_at           = date('Y-m-d H:i:s');
        $item->save();

        // save user_course
        $userCourse = new UserCourse;
        $userCourse->user_role_id   = \Auth::user()->userRolesTeacher()->id;
        $userCourse->course_id      = $item->id;
        $userCourse->created_at     = date('Y-m-d H:i:s');
        $userCourse->updated_at     = date('Y-m-d H:i:s');
        $userCourse->save();

        return \Response::json(array('status' => '200', 'message' => 'Course has been created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        if($id){
            $item = Course::find($id);

            if($item){
                $img_link = $item->image;

                if ($request->image != '') {
                    $img_file = $request->image;
                    list($type, $img_file) = explode(';', $img_file);
                    list(, $img_file) = explode(',', $img_file);
                    $img_file = base64_decode($img_file);
                    $file_name = time() . '.png';
                    file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
                    $img_link = $file_name;
                }

                $item->name                 = $request->name;
                $item->image                = $img_link;
                $item->short_description    = $request->short_description;
                $item->description          = $request->description;
                $item->will_learn           = $request->will_learn;
                $item->requirement          = $request->requirement;
                $item->price                = $request->price;
                $item->real_price           = $request->price;
                $item->level                = $request->level;
                $item->approx_time          = $request->approx_time;
                $item->category_id          = $request->category;
                $item->created_at           = date('Y-m-d H:i:s');
                $item->updated_at           = date('Y-m-d H:i:s');
                $item->save();

                return response()->json(array('status' => '200', 'message' => 'Course has been deleted!'));
            }     
        }
        return response()->json(array('status'=> '404', 'message' => 'Course not found'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->id){
            $course = Course::find($request->id);
            if($course){
                $course->status = -1;
                $course->save();

                return response()->json(array('status' => '200', 'message' => 'Course has been deleted!'));
            }     
        }
        return response()->json(array('status'=> '404', 'message' => 'Course not found'));
        
    }

    public function getGiveGift()
    {
        return view('backends.gifts.givegift');
    }
}