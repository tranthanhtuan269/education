<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Course;
use App\UserCourse;


class CourseController extends Controller
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

    // Course
    public function getCourse(){
        return view('backends.user.course');
    }

    public function getCourseAjax()
    {
        $courses = Course::get();
        return datatables()->collection($courses)
            ->addColumn('action', function ($course) {
                return $course->id;
            })
            ->addColumn('rows', function ($course) {
                return $course->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function accept(Request $request)
    {   
        if($request->course_id){
            $course = Course::find($request->course_id);
            
            if($course){
                $course->status = $request->status;
                
                if($request->status == 1){
                    // BaTV - Ktra xem tất cả các bài giảng trong khóa học đó đã được duyệt hết chưa
                    $count_course_active = Course::join('units', 'units.course_id', '=', 'courses.id')
                                                ->join('videos', 'videos.unit_id', '=', 'units.id')
                                                ->select('units.id')
                                                ->where('courses.id', $request->course_id)
                                                ->where('videos.state', 1)
                                                ->count();
                    $count_course_pending = Course::join('units', 'units.course_id', '=', 'courses.id')
                                                ->join('videos', 'videos.unit_id', '=', 'units.id')
                                                ->select('units.id')
                                                ->where('courses.id', $request->course_id)
                                                ->count();
                    
                    if ($count_course_active == $count_course_pending) {
                        $course->save();
                        $res = array('status' => "200", "message" => "Duyệt thành công");
                    } else {
                        $res = array('status' => "404", "message" => "Vẫn còn bài giảng trong khóa học chưa được duyệt, xin vui lòng kiểm tra lại tại <a href='".url('admincp/videos?search='.$course->name)."' target='_blank'>đây</a>");
                    }

                } else {
                    $course->save();
                    $res = array('status' => "200", "message" => "Hủy thành công");
                }

                echo json_encode($res);die;
            }
        }
        
        $res = array('status' => "401", "message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function acceptMultiCourse(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Course::acceptMulti($id_list, 1)) {
                $res = array('status' => 200, "message" => "Đã duyệt hết");
            } else {
                $res = array('status' => "204", "message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function inacceptMultiCourse(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Course::acceptMulti($id_list, 0)) {
                $res = array('status' => 200, "message" => "Đã hủy hết");
            } else {
                $res = array('status' => "204", "message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function deleteCourse(Request $request)
    {
        if($request->course_id){
            $course = Course::find($request->course_id);
            if($course){
                $course->delete();
                $res = array('status' => "200", "message" => "Xóa thành công");
                echo json_encode($res);die;
            }
        }
        $res = array('status' => "401", "message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function deleteMultiCourse(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Course::delMulti($id_list)) {
                $res = array('status' => 200, "message" => "Đã xóa hết");
            } else {
                $res = array('status' => "204", "message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }
}