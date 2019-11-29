<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Mail\ReleasedCourse;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Requests\UpdateFeatureCourseRequest;
use App\Course;
use App\UserCourse;
use App\Setting;
use Auth;
use App\Helper\Helper;
use App\TempCourse;
use Config;
use Mail;

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
    //         $item = Course::where('status', '!=', -100)->find($id);

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
            $course = Course::find($id);
            if ( $course->status == 0 ){
                $img_link = $course->image;

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

                $course->author               = \Auth::user()->name;
                $course->name                 = $request->name;
                $course->image                = $img_link;
                $course->short_description    = $request->short_description;
                $course->description          = $request->description;
                $course->will_learn           = $request->will_learn;
                $course->requirement          = $request->requirement;
                $course->price                = $request->discount_price;
                $course->real_price           = $request->original_price;
                $course->approx_time          = $request->approx_time;
                $course->category_id          = $request->category;
                $course->link_intro           = $link_intro;
                $course->updated_at           = date('Y-m-d H:i:s');
                $course->save();

                return response()->json(array('status' => '200', 'message' => 'Sửa khóa học thành công.'));
            }
            $temp_course = TempCourse::where('course_id', $id)->first();
            $flag = 1;
            if( !isset($temp_course->id) ){
                $temp_course = new TempCourse;
                $flag = 0;
            }
            $item = Course::find($id);

            if($item){
                if ( $flag ){
                    $img_link = $temp_course->image;
                }else{
                    $img_link = $item->image;
                }

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
            $course = Course::where('status', '!=', -100)->find($request->id);
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
            $course = Course::where('status', '!=', -100)->find($request->id);
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
        
        return view('backends.course.course');
    }

    public function getCourseAjax()
    {
        $courses = Course::where('status', '!=', -100)->get();
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
            $course = Course::where('status', '!=', -100)->find($request->course_id);
            
            if($course){
                if( $request->status == 1 ){
                    if( !isset($course->units[0]) ){
                        return \Response::json(array('status' => '404', 'message' => 'Không thể duyệt khóa học do không có phần học.'));
                    }
                    $video_count = 0;
                    $units = $course->units;
                    if(count($units) > 0){
                        foreach($units as $unit){
                            $video_count += count($unit->videosNoState);
                        }
                    }
                    if( $video_count == 0 ){
                        return \Response::json(array('status' => '404', 'message' => 'Không thể duyệt khóa học do không có bài học.'));
                    }
                }
                
                $course->status = $request->status;
                
                if($request->status == 1){
                    // BaTV - Ktra xem tất cả các bài giảng trong khóa học đó đã được duyệt hết chưa
                    $count_course_active = Course::where('status', '!=', -100)->join('units', 'units.course_id', '=', 'courses.id')
                                                ->join('videos', 'videos.unit_id', '=', 'units.id')
                                                ->select('units.id')
                                                ->where('courses.id', $request->course_id)
                                                ->whereIn('videos.state', [1,2,4])
                                                ->count();
                    $count_course_pending = Course::where('status', '!=', -100)->join('units', 'units.course_id', '=', 'courses.id')
                                                ->join('videos', 'videos.unit_id', '=', 'units.id')
                                                ->select('units.id')
                                                ->where('courses.id', $request->course_id)
                                                ->whereIn('videos.state', [0,1,2,3,4])
                                                ->count();
                    $count_course_convert = Course::where('status', '!=', -100)->join('units', 'units.course_id', '=', 'courses.id')
                                                ->join('videos', 'videos.unit_id', '=', 'units.id')
                                                ->select('units.id')
                                                ->where('courses.id', $request->course_id)
                                                ->where('videos.state', 3)
                                                ->count();
                    $count_course_request = Course::where('status', '!=', -100)->join('units', 'units.course_id', '=', 'courses.id')
                                                ->join('videos', 'videos.unit_id', '=', 'units.id')
                                                ->select('units.id')
                                                ->where('courses.id', $request->course_id)
                                                ->where('videos.state', 0)
                                                ->count();
                    if ($count_course_active == $count_course_pending) {
                        $course->save();
                        if (count($course->Lecturers()) > 0){
                            \App\Helper\Helper::addAlertCustomize($course->Lecturers()[0]->user, "Khóa học " . $course->name . "đã được duyệt", "Chúc mừng bạn! Khóa học <a href='" . url('/') . "/course/" . $course->id . "/" . $course->slug . "'>" . $course->name . "</a> đã được duyệt", true);
                        }
                        $res = array('status' => "200", "message" => "Duyệt thành công");
                    } else if($count_course_request > 0){
                        $res = array('status' => "404", "message" => "Vẫn còn bài giảng trong khóa học chưa được duyệt, xin vui lòng kiểm tra lại tại <a href='".url('admincp/videos?course_id='.$course->id)."' target='_blank'>đây</a>");
                    } else{
                        $res = array('status' => "404", "message" => "Các bài giảng đang convert, vui lòng quay lại phê duyệt sau khi convert thành công. Xem chi tiết tại <a href='".url('admincp/videos?course_id='.$course->id)."' target='_blank'>đây</a>.");
                    }

                } else {
                    // dd($course->userRoles->first()->teacher->featured);
                    if( $course->userRoles->first()->teacher->featured == 1 ){
                        return \Response::json(array('status' => '301', 'message' => 'Không thể hủy khóa học của giảng viên tiêu biểu.'));
                    }

                    $course->save();
                    $res = array('status' => "200", "message" => "Hủy thành công");
                }

                echo json_encode($res);die;
            }
        }
        
        $res = array('status' => "401", "message" => 'Thao tác không thành công.');
        echo json_encode($res);die;
    }

    public function deleteCourse(Request $request)
    {   
        $course = Course::where('status', '!=', -100)->find($request->course_id);
        if ( $course ){
            if ( $course->status == 0 ){
                $units = $course->units;
                if ( $units ){
                    if ( $units->count() > 0 ){
                        foreach ( $units as $unit ){
                            $videos = $unit->videos;
                            if ( $videos ){
                                if ( $videos->count() > 0 ){
                                    foreach ( $videos as $video ){
                                        $documents = \App\Document::where('video_id', $video->id)->get();
                                        if ( $documents ){
                                            if ( $documents->count() > 0 ){
                                                foreach ( $documents as $document ){
                                                    if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                                                        unlink(public_path('uploads/files/'.$document->url_document));
                                                    }
                                                    $document->delete();
                                                }
                                            }
                                        }
                                        if ( $video->link_video ){
                                            if(\File::exists(public_path('uploads/videos/'.$video->link_video))) {
                                                \File::delete(public_path('uploads/videos/'.$video->link_video));
                                            }
                                        }
                                        $video->delete();
                                    }
                                }
                            }
                            $unit->delete();
                        }
                    }
                }
                // add alert
                \App\Helper\Helper::addAlertCustomize($course->Lecturers()[0]->user, "Khóa học <strong>" . $course->name . "</strong> đã bị xóa", "Khóa học <strong>" . $course->name . "</strong> của bạn đã bị xóa khỏi hệ thống của chúng tôi. Do nó đã không tuân thủ một só quy định hoặc không đáp ứng được tiêu chí mà chúng tôi đề ra.", true);

                $user_course = \App\UserCourse::where('course_id', $course->id)->delete();
                $course->delete();
                return response()->json([
                    'status' => '200',
                    'message' => 'Xóa khóa học thành công.'
                ]);
            }
        }
        return response()->json([
            'status' => '404',
            'message' => 'Thao tác không thành công.'
        ]);
    }

    public function getFeatureCourse(){
        $courses = Course::listCourseSpecial(2)->get();
        $percent = Setting::where('name', 'percent_feature_course')->first()->value;
        return view('backends.course.feature-course', compact('courses', 'percent'));
    }

    public function handlingFeatureCourseAjax(UpdateFeatureCourseRequest $request){
        $course = Course::where('status', '!=', -100)->where('featured', '>', 0)->update(['featured_index' => 0,'featured' => 0]);

        $course1 = Course::where('status', '!=', -100)->find($request->course_1);
        $course1->featured       = 1;
        $course1->featured_index = 1;
        $course1->save();

        $course2 = Course::where('status', '!=', -100)->find($request->course_2);
        $course2->featured       = 1;
        $course2->featured_index = 2;
        $course2->save();

        $course3 = Course::where('status', '!=', -100)->find($request->course_3);
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
        $course = Course::where('status', '!=', -100)->find($request->course_id);
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
                \App\Helper\Helper::addAlertCustomize($course->Lecturers()[0]->user, "Yêu cầu sửa khóa học " . $course->name . " đã được duyệt", "Chúc mừng bạn! Yêu cầu sửa khóa học <a href='" . url('/') . "/course/" . $course->id . "/" . $course->slug . "'>" . $course->name . "</a> đã được duyệt", true);
                $course->save();
                $temp_course->delete();
                return response()->json(array('status' => '200', 'message' => 'Duyệt yêu cầu sửa khóa học thành công.'));
                }
            }else{
                \App\Helper\Helper::addAlertCustomize($course->Lecturers()[0]->user, "Khóa học " . $course->name . "đã bị hủy yêu cầu sửa", "Xin lỗi bạn! Yêu cầu sửa khóa học <a href='" . url('/') . "/course/" . $course->id . "/" . $course->slug . "'>" . $course->name . "</a> đã bị hủy", true);
                $temp_course->delete();
                return response()->json(array('status' => '403', 'message' => 'Hủy yêu cầu sửa khóa học thành công.'));
            }
        }
    }

    public function getRequestAccept()
    {
        return view('backends.course.request-accept-course');
    }

    public function getRequestAcceptCourseAjax()
    {
        $courses = Course::where('status', '!=', -100)->where('status', Config::get('app.course_waiting'))->get();
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
            ->addColumn('teacher', function ($course) {
                if ( $course->userRoles()->count() > 0 ){
                    if ( $course->userRoles()->first()->user ){
                        return $course->userRoles()->first()->user->name;
                    }
                }
                return 'Giảng viên Courdemy';
            })
            ->removeColumn('id')
            ->make(true);
    }

    public function getAcceptedCourse()
    {
        return view('backends.course.accepted-course');
    }

    public function getAcceptedCourseAjax()
    {
        $courses = Course::where('status', '!=', -100)->whereIn('status', [Config::get('app.course_active'), Config::get('app.course_stop_selling')])->get();
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
            ->addColumn('teacher', function ($course) {
                if ( $course->userRoles()->count() > 0 ){
                    if ( $course->userRoles()->first()->user ){
                        return $course->userRoles()->first()->user->name;
                    }
                }
                return 'Giảng viên Courdemy';
            })
            ->removeColumn('id')
            ->make(true);
    }

    public function stopSellingCourse(Request $request)
    {
        $course = Course::where('status', '!=', -100)->find($request->course_id);
        if ( $course ){
            if ( $course->status == Config::get('app.course_active') ){
                if ( $course->userRoles->first()->teacher ){
                    if( $course->userRoles->first()->teacher->featured == 1 ){
                        return \Response::json(array('status' => '404', 'message' => 'Không thể ngừng bán khóa học của giảng viên tiêu biểu.'));
                    }
                }
                if ( $course->featured == 1 ){
                    return response()->json(array('status' => '404', 'message' => 'Không thể ngừng bán khóa học nổi bật.'));
                }else{
                    $course->status = Config::get('app.course_stop_selling');
                    $course->save();
                    \App\Helper\Helper::addAlertCustomize($course->Lecturers()[0]->user, "Yêu cầu ngừng bán khóa học " . $course->name . "đã được duyệt", "Chúc mừng bạn! Yêu cầu ngừng bán khóa học <a href='" . url('/') . "/course/" . $course->id . "/" . $course->slug . "'>" . $course->name . "</a> đã được duyệt", true);
                    return response()->json(array('status' => '200', 'message' => 'Khóa học của bạn đã được ngừng bán.'));
                }
            }
            if ( $course->status == Config::get('app.course_stop_selling') ){
                $course->status = Config::get('app.course_active');
                $course->save();
                \App\Helper\Helper::addAlertCustomize($course->Lecturers()[0]->user, "Yêu cầu bán khóa học " . $course->name . "đã được duyệt", "Chúc mừng bạn! Yêu cầu bán khóa học <a href='" . url('/') . "/course/" . $course->id . "/" . $course->slug . "'>" . $course->name . "</a> đã được duyệt", true);
                return response()->json(array('status' => '200', 'message' => 'Khóa học của bạn đã được tiếp tục bán.'));
            }
            return response()->json(array('status' => '404', 'message' => 'Thao tác không thành công.'));
        }
        return response()->json(array('status' => '404', 'message' => 'Thao tác không thành công.'));
    }

    public function checkRequestEditCourse(Request $request)
    {
        $check = TempCourse::where('course_id', $request->course_id)->get();
        if ( $check ){
            if ( $check->count() > 0 ){
                return response()->json(array('status' => '200', 'result' => true ));
            }else{
                return response()->json(array('status' => '200', 'result' => false ));
            }
        }else{
            return response()->json(array('status' => '404'));
        }
    }

    public function viewRequestEditCourse(Request $request)
    {
        $edit_course = TempCourse::where('course_id', $request->course_id);
        if ( $edit_course ){
            $edit_course = $edit_course->first();
            return response()->json(array(
                'status'    => '200',
                'image'     => $edit_course->image,
                'name'      => $edit_course->name,
                'short_description' => $edit_course->short_description,
                'description'   => $edit_course->description,
                'requirement'   => $edit_course->requirement,
                'video'         => $edit_course->link_intro,
                'real_price'    => $edit_course->real_price,
                'price'         => $edit_course->price,
                'approx_time'   => $edit_course->approx_time,
                'category_id'   => $edit_course->category_id,
                'will_learn'    => $edit_course->will_learn,
            ));
        }else{
            return response()->json(array('status' => '404'));
        }
    }
}