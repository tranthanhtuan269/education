<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Requests\UpdateFeatureCourseRequest;
use App\Course;
use App\UserCourse;
use App\Setting;
use Auth;
use App\Helper\Helper;
use App\TempCourse;


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

        // if($request->will_learn){
        //     $will_learn = explode(";;", $request->will_learn);
        //     $will_learn = \json_encode($will_learn);
        // }

        // if($request->requirement){
        //     $requirement = explode(";;", $request->requirement);
        //     $requirement = \json_encode($requirement);
        // }

        $item = new Course;
        $item->author               = \Auth::user()->name;
        $item->name                 = $request->name;
        $item->image                = $img_link;
        $item->short_description    = $request->short_description;
        $item->description          = $request->description;
        $item->will_learn           = $request->will_learn;
        $item->requirement          = $request->requirement;
        $item->price                = $request->discount_price;
        $item->real_price           = $request->original_price;
        $item->approx_time          = $request->approx_time;
        $item->category_id          = $request->category;
        $item->link_intro           = "https://www.youtube.com/embed/" . Helper::getYouTubeVideoId($request->link_intro);
        $item->created_at           = date('Y-m-d H:i:s');
        $item->updated_at           = date('Y-m-d H:i:s');
        $item->save();

        // lưu vào trường products gồm những bài giảng user này đã đăng ký
        $products = [];
        $current_user = \Auth::user();
        if (strlen($current_user->products) > 0) {
            $products = \json_decode($current_user->products);
        }
        $products[] = $item->id;
        $current_user->products = \json_encode($products);
        $current_user->save();

        // lưu vào bảng user_course
        $userCourse = new UserCourse;
        $userCourse->user_role_id   = $current_user->userRolesTeacher()->id;
        $userCourse->course_id      = $item->id;
        $userCourse->created_at     = date('Y-m-d H:i:s');
        $userCourse->updated_at     = date('Y-m-d H:i:s');
        $userCourse->save();

        //tăng lượng course cho teacher trong bảng teachers
        $teacherInstance = Auth::user()->userRolesTeacher()->teacher;
        if(isset($teacherInstance)){
            $teacherInstance->course_count += 1;
            $teacherInstance->save();
        }

        return \Response::json(array('status' => '200', 'message' => 'Tạo khóa học thành công!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateCourseRequest $request, $id)
    // {
    //     if($id){
    //         $item = Course::find($id);

    //         if($item){
    //             $img_link = $item->image;

    //             if ($request->image != '') {
    //                 $img_file = $request->image;
    //                 list($type, $img_file) = explode(';', $img_file);
    //                 list(, $img_file) = explode(',', $img_file);
    //                 $img_file = base64_decode($img_file);
    //                 $file_name = time() . '.png';
    //                 file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
    //                 $img_link = $file_name;
    //             }

    //             $link_intro = "https://www.youtube.com/embed/" . Helper::getYouTubeVideoId($request->link_intro);

    //             $item->author               = \Auth::user()->name;
    //             $item->name                 = $request->name;
    //             $item->image                = $img_link;
    //             $item->short_description    = $request->short_description;
    //             $item->description          = $request->description;
    //             $item->will_learn           = $request->will_learn;
    //             $item->requirement          = $request->requirement;
    //             $item->price                = $request->discount_price;
    //             $item->real_price           = $request->original_price;
    //             $item->approx_time          = $request->approx_time;
    //             $item->category_id          = $request->category;
    //             $item->link_intro           = $link_intro;
    //             $item->created_at           = date('Y-m-d H:i:s');
    //             $item->updated_at           = date('Y-m-d H:i:s');
    //             $item->save();

    //             return response()->json(array('status' => '200', 'message' => 'Gửi thành công yêu cầu sửa khóa học.'));
    //         }     
    //     }
    //     return response()->json(array('status'=> '404', 'message' => 'Không tìm thấy khóa học!'));
    // }

    public function update(UpdateCourseRequest $request, $id)
    {

        if($id){
            $temp_course = TempCourse::where('course_id', $id)->first();
            if( !isset($temp_course->id) ){
                $temp_course = new TempCourse;
            }
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

                $link_intro = "https://www.youtube.com/embed/" . Helper::getYouTubeVideoId($request->link_intro);

                $temp_course->course_id            = $id;
                $temp_course->author               = \Auth::user()->name;
                $temp_course->name                 = $request->name;
                $temp_course->image                = $img_link;
                $temp_course->short_description    = $request->short_description;
                $temp_course->description          = $request->description;
                $temp_course->will_learn           = $request->will_learn;
                $temp_course->requirement          = $request->requirement;
                $temp_course->price                = $request->discount_price;
                $temp_course->real_price           = $request->original_price;
                $temp_course->approx_time          = $request->approx_time;
                $temp_course->category_id          = $request->category;
                $temp_course->link_intro           = $link_intro;
                $temp_course->created_at           = date('Y-m-d H:i:s');
                $temp_course->save();

                return response()->json(array('status' => '200', 'message' => 'Gửi yêu cầu sửa khóa học thành công. Hãy chờ Admin xét duyệt.'));
            }     
        }
        return response()->json(array('status'=> '404', 'message' => 'Không tìm thấy khóa học!'));
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
            $teacher_course = $course->userRoles()->first()->user->id;
            if( $course && $teacher_course ){
                if( $teacher_course == $request->user_id ){
                    $course->status = -1;
                    $course->save();
                    return response()->json(array('status' => '200', 'message' => 'Khóa học của bạn đã được ngừng bán.'));
                }
            }     
        }
        return response()->json(array('status'=> '404', 'message' => 'Thao tác không thành công.'));
    }

    public function continueSell(Request $request)
    {
        if($request->id){
            $course = Course::find($request->id);
            $teacher_course = $course->userRoles()->first()->user->id;
            if( $course && $teacher_course ){
                if( $teacher_course == $request->user_id ){
                    if ( $course->status == -1 ){
                        $course->status = 1;
                        $course->save();
                        return response()->json(array('status' => '200', 'message' => 'Khóa học của bạn đã được tiếp tục bán.'));
                    }
                }
            }     
        }
        return response()->json(array('status'=> '404', 'message' => 'Thao tác không thành công.'));
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
            ->removeColumn('id')
            ->rawColumns(['description'])
            ->make(true);
    }

    public function accept(Request $request)
    {   

        if($request->course_id){
            $course = Course::find($request->course_id);
            
            if( $request->status == 1 ){
                if( !isset($course->units) ){
                    return \Response::json(array('status' => '404', 'message' => 'Không thể duyệt khóa học do không có phần học.'));
                }else{
                    if( !isset($course->units[0]->videos) ){
                        return \Response::json(array('status' => '404', 'message' => 'Không thể duyệt khóa học do phần học không có bài học.'));
                    }
                }
            }

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
                        $res = array('status' => "404", "message" => "Vẫn còn bài giảng trong khóa học chưa được duyệt, xin vui lòng kiểm tra lại tại <a href='".url('admincp/videos?search='.$course->name)."&course_id=".$course->id."' target='_blank'>đây</a>");
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

    public function getFeatureCourse(){
        $courses = Course::where('status', 1)->get();
        $percent = Setting::where('name', 'percent_feature_course')->first()->value;
        return view('backends.course.feature-course', compact('courses', 'percent'));
    }

    public function handlingFeatureCourseAjax(UpdateFeatureCourseRequest $request){
        $course = Course::where('featured', '>', 0)->update(['featured_index' => 0,'featured' => 0]);

        $course1 = Course::find($request->course_1);
        $course1->featured       = 1;
        $course1->featured_index = 1;
        $course1->save();

        $course2 = Course::find($request->course_2);
        $course2->featured       = 1;
        $course2->featured_index = 2;
        $course2->save();

        $course3 = Course::find($request->course_3);
        $course3->featured       = 1;
        $course3->featured_index = 3;
        $course3->save();

        if($request->percent_feature_course != null){
            $setting_percent_feature_course = Setting::where('name', 'percent_feature_course')->first();
            $setting_percent_feature_course->value = $request->percent_feature_course;
            $setting_percent_feature_course->save();
        }

        return \Response::json(array('status' => '200', 'message' => 'Thay đổi khóa học nổi bật thành công!'));
    }

    public function getRequestEditCourse(){
        
        return view('backends.course.request-edit-course');
    }

    public function getRequestEditCourseAjax()
    {
        $courses = TempCourse::get();
        return datatables()->collection($courses)
            ->addColumn('action', function ($course) {
                return $course->id;
            })
            ->addColumn('rows', function ($course) {
                return $course->id;
            })
            ->addColumn('category', function ($course) {
                return $course->category->name;
            })
            ->removeColumn('id')
            ->make(true);
    }

    public function acceptEditCourse(Request $request)
    {
        $temp_course = TempCourse::find($request->id);
        $course = Course::find($request->course_id);
        $accept = $request->accept;

        if( $temp_course ){
            if( $accept ){
                if( $course ){
                $course->name                 = $temp_course->name;
                $course->author               = $temp_course->author;
                $course->short_description    = $temp_course->short_description;
                $course->slug                 = $temp_course->slug;
                $course->image                = $temp_course->image;
                $course->description          = $temp_course->description;
                $course->will_learn           = $temp_course->will_learn;
                $course->requirement          = $temp_course->requirement;
                $course->price                = $temp_course->price;
                $course->real_price           = $temp_course->real_price;
                $course->approx_time          = $temp_course->approx_time;
                $course->category_id          = $temp_course->category_id;
                $course->link_intro           = $temp_course->link_intro;
                $course->updated_at           = date('Y-m-d H:i:s');
                $course->save();
                $temp_course->delete();
                return response()->json(array('status' => '200', 'message' => 'Duyệt yêu cầu sửa khóa học thành công.'));
                }
            }else{
                $temp_course->delete();
                return response()->json(array('status' => '403', 'message' => 'Hủy yêu cầu sửa khóa học thành công.'));
            }
        }
    }
}