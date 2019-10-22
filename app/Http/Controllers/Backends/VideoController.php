<?php

namespace App\Http\Controllers\Backends;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Transformers\VideoTransformer;
use App\Course;
use App\Unit;
use App\Video;
use App\UserCourse;
use App\UserRole;
use App\User;
use App\Document;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Jobs\ProcessLecture;
use App\Jobs\ProcessLecture1080;
use App\Jobs\ProcessLectureEdit;
use App\Jobs\ProcessLectureEdit1080;
use DB;
use Illuminate\Http\Response;
use Config;
use App\TempVideo;
use App\TempDocument;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVideoRequest $request
     * @return Response
     */
    public function store(StoreVideoRequest $request)
    {
        $unit = Unit::withCount('videos')->find($request->unit_id);
        if ($unit) {
            $video = new Video;
            $video->name = $request->name;
            $video->unit_id = $request->unit_id;
            $video->description = $request->description;
            $video->index = $unit->videos_count+1;
            $video->url_video = json_encode(['a' => 'b']);

            if ($request->link_video != '') {
                $link_video = $request->link_video . '.mp4';
                $video->link_video = $link_video;
                $command = config('config.path_ffprobe_exe') . ' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . public_path("/uploads/videos/") . $link_video . ' 2>&1';
                $video->duration = exec($command, $output, $return);
            }
            $video->save();

            //DuongNT upload file
            if($request->file()){
                foreach ($request->file() as $key => $file) {
                    if($file->isValid()){
                        $file_name = $file->getClientOriginalName();
                        $file_name = str_replace(" ", "_", $file->getClientOriginalName());

                        $document = new Document;
                        $document->title = $file->getClientOriginalName();
                        $document->video_id = $video->id;
                        $document->url_document = $video->id.'_'.time().'_'.$file_name;
                        $document->size = $file->getClientSize();
                        $document->save();

                        $file->move('uploads/files', $video->id.'_'.time().'_'.$file_name);
                    }else{
                        return response()->json([
                            'status' => "401",
                            'message' => "File bị lỗi khi upload!"
                        ]);
                    }
                }
            }

            $unit = $video->unit;
            $unit->video_count += 1;
            $unit->save();

            $course = $video->unit->course;
            $course->video_count += 1;
            $course->save();

            // DuongNT // thêm 1 video vào lượng đã xem vào bảng user_courses
            // $user_roles = $course->userRoles()->get()->all();
            // $user_roles = \array_filter($user_roles, function($user_role){
            //     return $user_role->role_id == 3; //lấy những user_role đại diện student
            // });
            // #Insert cho từng student
            // foreach ($user_roles as $key => $user_role) {
            //     $user_course = UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
            //     $videos = json_decode($user_course->videos);
            //     array_push($videos->{'videos'}[($unit->index) - 1 ], 0);
            //     $videos = json_encode($videos);
            //     $user_course->videos = $videos;
            //     $user_course->save();
            // }


            return response()->json([
                'status' => '200',
                'message' => 'New video is created!',
                'video' => fractal($video, new VideoTransformer())->toArray(),
            ]);
        }

        return response()->json([
            'status' => '404',
            'message' => 'Cannot create new video! There was a problem!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request)
    {
        dd($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateVideoRequest $request, $id)
    {
        // dd($request->all());
        $video = Video::find($id);
        if($video){
            $video->name = $request->name;
            $video->description = $request->description;

            if ($request->link_video != '') {
                $link_video = $request->link_video.'.mp4';
                $video->link_video = $link_video;
                $command = config('config.path_ffprobe_exe').' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 '.public_path("/uploads/videos/").$link_video.' 2>&1';
                $video->duration =  exec($command, $output, $return);
            }

            $video->save();

            //DuongNT upload file
            if($request->file()){
                foreach ($request->file() as $key => $file) {
                    if($file->isValid()){
                        $file_name = $file->getClientOriginalName();
                        $file_name = str_replace(" ", "_", $file->getClientOriginalName());

                        $document = new Document;
                        $document->title = $file->getClientOriginalName();
                        $document->video_id = $video->id;
                        $document->url_document = $video->id.'_'.time().'_'.$file_name;
                        $document->size = $file->getClientSize();
                        $document->save();

                        $file->move('uploads/files', $video->id.'_'.time().'_'.$file_name);
                    }else{
                        return response()->json([
                            'status' => "401",
                            'message' => "File bị lỗi khi upload!"
                        ]);
                    }
                }
            }

            if($request->active_file_to_delete){
                $document_ids = explode(",", $request->active_file_to_delete);
                foreach ($document_ids as $key => $id) {
                    $document = Document::find($id);
                    unlink(public_path('uploads/files/'.$document->url_document));
                    $document->delete();
                }
            }

            return \Response::json(array('status' => '200', 'message' => 'Sửa Video thành công!', 'video' => $video));
        }
        return \Response::json(array('status' => '404', 'message' => 'Sửa Video không thành công!'));
    }

    public function requestUpdate(UpdateVideoRequest $request, $id)
    {
        $video = Video::find($id);
        if($video){

            $replace_temp = TempVideo::where('video_id', $id)->first();
            if( $replace_temp ){
                $replace_temp->delete();
            }

            $documents = TempDocument::where('video_id', $video->id)->delete();

            $temp_video = new TempVideo;
            $temp_video->video_id  = $id;
            $temp_video->name      = $request->name;

            if ($request->link_video != '') {
                $link_video = $request->link_video.'.mp4';
                $temp_video->link_video = $link_video;
                $command = config('config.path_ffprobe_exe').' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 '.public_path("/uploads/videos/").$link_video.' 2>&1';
                $temp_video->duration =  exec($command, $output, $return);
            }

            $temp_video->description = $request->description;
            $temp_video->unit_id     = $video->unit_id;

            //DuongNT upload file
            if($request->file()){
                foreach ($request->file() as $key => $file) {
                    if($file->isValid()){
                        $file_name = $file->getClientOriginalName();
                        $file_name = str_replace(" ", "_", $file->getClientOriginalName());

                        $document = new TempDocument;
                        $document->title = $file->getClientOriginalName();
                        $document->video_id = $video->id;
                        $document->url_document = $video->id.'_'.time().'_'.$file_name;
                        $document->size = $file->getClientSize();
                        $document->save();
                        $file->move('uploads/files', $video->id.'_'.time().'_'.$file_name);
                    }else{
                        return response()->json([
                            'status' => "401",
                            'message' => "File bị lỗi khi upload!"
                        ]);
                    }
                }
            }

            if($request->active_file_to_delete){
                $temp_video->files_delete = $request->active_file_to_delete;
            }

            $video->state = Config::get('app.video_request_edit');
            $video->save();
            $temp_video->save();

            return \Response::json(array('status' => '200', 'message' => 'Gửi yêu cầu sửa video thành công.', 'video' => $video));
        }
        return \Response::json(array('status' => '404', 'message' => 'Thao tác không thành công!'));
    }

    public function removeRequestUpdate(Request $request)
    {
        $video  = Video::find($request->video_id);
        if ( $video ){
            if ( $video->state == Config::get('app.video_request_edit') ){

                $remove_documents = TempDocument::where('video_id', $request->video_id)->get();
                if ( $remove_documents->count() > 0 ){
                    foreach ($remove_documents as $key => $document) {
                        if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                            unlink(public_path('uploads/files/'.$document->url_document));
                        }
                        $document->delete();
                    }
                }

                $remove_videos = TempVideo::where('video_id', $request->video_id)->first();
                if ( $remove_videos ){
                    if ( $remove_videos->link_video ){
                        if (file_exists(public_path('uploads/files/'.$remove_videos->url_document))) {
                            unlink(public_path('uploads/videos/'.$remove_videos->link_video));
                        }
                    }
                    $remove_videos->delete();
                }else{
                    return \Response::json(array('status' => '404', 'message' => 'Thao tác không thành công.'));
                }

                $video->state = Config::get('app.video_active');
                $video->save();
                return \Response::json(array('status' => '200', 'message' => 'Hủy yêu cầu thành công.'));
            }
        }
        return \Response::json(array('status' => '404', 'message' => 'Thao tác không thành công.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function sendRemoveVideoRequest(Request $request)
    {
        $video = Video::find($request->video_id);

        if ($video) {
            // if($video->state == Config::get('app.video_active')){ //Đang được admin duyệt
            //     return response()->json([
	        //         'status' => '201',
	        //         'message' => 'Yêu cầu xoá video bài giảng đang được duyệt!'
	        //     ]);
            // }
            // if($video->state == Config::get('app.video_rejected')){
            //     return response()->json([
            //         'status' => '201',
            //         'message' => 'Video đã không được duyệt!'
            //     ]);
            // }
            // if($video->state == Config::get('app.video_waiting')){  // Nếu đang chờ duyệt thì có thể xoá luôn
            //     //Xoá luôn video trên server
	        //     $json_video = json_decode($video->url_video, true);
	        //     if (count($json_video) > 0) {
	        //         foreach ($json_video as $path_video) {
	        //             if(\File::exists($path_video)) {
	        //                 \File::delete($path_video);
	        //             }
	        //         }
            //     }
            //     $video->delete();
            //     return response()->json([
            //         'status' => '200',
            //         'message' => 'Xoá video bài giảng thành công!'
            //     ]);
            // }
            if($video->state == Config::get('app.video_waiting')){  // Nếu đang chờ duyệt thì có thể xoá luôn
                // Xoa documents
                $documents = Document::where('video_id', $video->id)->get();
                if ( $documents->count() > 0 ){
                    foreach ($documents as $key => $document) {
                        if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                            unlink(public_path('uploads/files/'.$document->url_document));
                        }
                        $document->delete();
                    }
                }
                //Xoá luôn video trên server
                $path_video = public_path('uploads/videos/'.$video->link_video);
                if(\File::exists($path_video)) {
                    \File::delete($path_video);
                }
                $video->delete();
                return response()->json([
                    'status' => '200',
                    'message' => 'Xoá video bài giảng thành công.'
                ]);
            }

            if($video->state == Config::get('app.video_active')){
                // $unit = $video->unit;
                // $course = $unit->course;
                $video->state = Config::get('app.video_waiting_to_delete'); //Đang được admin duyệt để xoá
                $video->save();

                return response()->json([
	                'status' => '200',
	                'message' => 'Yêu cầu xoá video đã được gửi.'
	            ]);

                //Xoá luôn video trên server
	            // if (count($json_video) > 0) {
	            //     foreach ($json_video as $path_video) {
	            //         if(\File::exists($path_video)) {
	            //             \File::delete($path_video);
	            //         }
	            //     }
                // }

                // DuongNT // Xoá trong bảng usercourse phần tử đại diện video đã xem
                // $unit = $video->unit;
                // $course = $video->unit->course;
                // $user_roles = $course->userRoles()->get()->all();
                // $user_roles = \array_filter($user_roles, function($user_role){
                //     return $user_role->role_id == 3; //lấy những user_role đại diện student
                // });
                // foreach ($user_roles as $key => $user_role) {
                //     $user_course = UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                //     $videos = json_decode($user_course->videos);
                //     $unit_arr = $videos->{'videos'}[ ($unit->index) - 1 ];
                //     array_splice($unit_arr, ($video->index - 1), 1);
                //     $videos->{'videos'}[ ($unit->index) - 1 ] = $unit_arr;
                //     $videos = json_encode($videos);
                //     $user_course->videos = $videos;
                //     $user_course->save();
                // }

	            // $video->delete();


            }
        }else{
            return response()->json([
                'status' => '404',
                'message' => 'Thao tác không thành công.',
            ]);
        }
    }

    public function sort(Request $request)
    {
        if ($request->data) {
            $list = json_decode($request->data);

            $course = 0;
            $unit = 0;
            $video = 0;
            foreach ($list as $obj) {
                $video = Video::find($obj->id);

                $old_video_index = $video->index;
                if ($video) {
                    $video->index = $obj->index+1;
                    $unit = $video->unit;
                    $course = $video->unit->course;

                    $video->save();
                }
            }

            $user_roles = $course->userRoles()->where('role_id', 3)->get();
            foreach ($user_roles as $key => $user_role) {
                $user_course = UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                $videos = json_decode($user_course->videos);
                $unit_arr = $videos->{'videos'}[($unit->index)-1];
                Helper::moveElementInArray($unit_arr, $request->old_pos - 1, $request->new_pos - 1);
                $videos->{'videos'}[($unit->index)-1] = $unit_arr;
                $videos = json_encode($videos);
                $user_course->videos = $videos;
                $user_course->save();
            }
            return \Response::json(array('status' => '200', 'message' => 'Sửa Video thành công!'));
        }
        return \Response::json(array('status' => '404', 'message' => 'Sửa Video không thành công!'));
    }

    public function verifyVideo()
    {
        $myvideo = Video::find(12);
        return view('backends.videos.verify', [
            'myvideo' => $myvideo,
        ]);
    }

    public function getUnverifiedVideoAjax()
    {
        $videos = Video::where('state', 0)->get();
        return datatables()->collection($videos)
            ->addColumn('name', function ($video) {
                return $video->name;
            })
            ->addColumn('description', function ($video) {
                return $video->description;
            })
            ->addColumn('teacherName', function ($video) {
                return $video->unit != null ? $video->unit->course->name : "";
            })
            ->addColumn('action', function ($video) {
                return $video;
            })
            ->addColumn('rows', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function acceptVideo(Request $request)
    {
        $video = Video::find($request->video_id);
        if ($video) {
            $unit  = $video->unit;
            $course = $unit->course;
            $user_roles_teacher = $course->Lecturers()->first();
            if($user_roles_teacher){
                $user = $user_roles_teacher->user;
                $isTeacher = $user->isTeacher();
                if(!$isTeacher){
                   return response()->json([
                       'status' => 300,
                       'message'=> 'Giảng viên chưa được duyệt. Vui lòng duyệt giảng viên trước!'
                   ]);
                }
            }

            $video->state = Config::get('app.video_converting');
            $video->save();

            // DuongNT // thêm 1 video vào lượng đã xem vào bảng user_courses
            $unit = $video->unit;
            $course = $unit->course;
            $user_roles = $course->userRoles()->where('role_id', Config::get('app.student'))->get()->all();//lấy những user_role đại diện student
            #Insert cho từng student

            // foreach ($user_roles as $key => $user_role) {
            //     $user_course = UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
            //     $videos = json_decode($user_course->videos);
            //     array_push($videos->{'videos'}[($unit->index) - 1 ], 0);
            //     $videos = json_encode($videos);
            //     $user_course->videos = $videos;
            //     $user_course->save();
            // }

            return response()->json([
                'status' => 200,
                'message' => 'Bài giảng đã được duyệt!',
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Không tìm thấy bài giảng!',
        ]);
    }

    public function getVideo()
    {
        if( isset($_GET['course_id']) ){
            return view('backends.videos.videoOfCourse');
        }
        return view('backends.videos.video');
    }

    public function getVideoAjax()
    {
        if( isset($_GET['course_id']) ){
            $course_id = $_GET['course_id'];
            $sql = "
            SELECT videos.id, videos.name as name, videos.link_video as link_video, videos.updated_at as updated_at, courses.name as course_name, courses.id as course_id, videos.state
            FROM courses
            JOIN units ON units.course_id = courses.id
            JOIN videos ON videos.unit_id = units.id
            WHERE courses.id IN (".$course_id.")
            ";
            $videos = \DB::select($sql);
            return datatables()->collection(collect($videos))
                ->addColumn('action', function ($video) {
                    return $video->id;
                })
                ->removeColumn('id')->make(true);
        }
        $sql = "
        SELECT videos.id, videos.state, videos.name, videos.link_video, videos.updated_at, courses.name as course_name
        FROM videos
        JOIN units ON units.id = videos.unit_id
        JOIN courses ON courses.id = units.course_id
        WHERE videos.state IN (0,1,2,3,4)
        ";
        $videos = \DB::select($sql);
        return datatables()->collection(collect($videos))
            ->addColumn('action', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function accept(Request $request)
    {
        if ($request->video_id != null) {
            $video = Video::find($request->video_id);

            if ($video) {
                $unit  = $video->unit;
                $course = $unit->course;
                $user_roles_teacher = $course->Lecturers()->first();
                if($user_roles_teacher){
                    $user = $user_roles_teacher->user;
                    if ( $user ){
                        $isTeacher = $user->isTeacher();
                        if(!$isTeacher){
                            return response()->json([
                                'status' => 300,
                                "message"=> "Giảng viên chưa được duyệt. Vui lòng kiểm tra tại <a href='".url('admincp/teachers?teacher_id='.$user_roles_teacher->teacher->id)."' target='_blank'>đây</a>!"
                            ]);
                        }
                    }else{
                        return response()->json([
                            'status' => 301,
                            "message"=> "Giảng viên đã bị xóa hoặc đang được cập nhật."
                        ]);
                    }
                }
                // Sap xep lai user_courses->videos
                if ( $course ){
                    Helper::reBuildJsonWhenCreateOrDeleteLecture($course->id, $video->id, 1);
                }
                if ($request->state == 3) { //state = 3 đang đợi convert trong hàng đợi
                    // convert video to multi resolution
                    $path_360 = "/usr/local/WowzaStreamingEngine-4.7.7/content/360/".$video->link_video;
                    $path_480 = "/usr/local/WowzaStreamingEngine-4.7.7/content/480/".$video->link_video;
                    $path_720 = "/usr/local/WowzaStreamingEngine-4.7.7/content/720/".$video->link_video;
                    $path_1080 = "/usr/local/WowzaStreamingEngine-4.7.7/content/1080/".$video->link_video;

                    $content_path_360 = "vod/_definst_/360/".$video->link_video;
                    $content_path_480 = "vod/_definst_/480/".$video->link_video;
                    $content_path_720 = "vod/_definst_/720/".$video->link_video;
                    $content_path_1080 = "vod/_definst_/1080/".$video->link_video;

                    $json = '{"360": "'.$content_path_360.'", "480": "'.$content_path_480.'", "720": "'.$content_path_720.'", "1080": "'.$content_path_1080.'"}';
                    // echo json_encode($json);die;
                    // $video->url_video = $json;
                    // $video->url_video = json_encode($json);
                    $video->url_video = $json;
                    $video->save();

                    dispatch(new ProcessLecture($path_360, $request->video_id, $video->link_video, 360));
                    dispatch(new ProcessLecture($path_480, $request->video_id, $video->link_video, 480));
                    dispatch(new ProcessLecture($path_720, $request->video_id, $video->link_video, 720));
                    dispatch(new ProcessLecture1080($path_1080, $request->video_id, $video->link_video, 1080));

                    $res = array('status' => "200", "message" => "Duyệt thành công. Bài giảng đang được convert");
                } else {
                    // BaTV - Nếu hủy bất kỳ video nào trong khóa học đó =>  Khóa học tương ứng sẽ hủy theo

                    $course = $video->unit->course;
                    $course->status = 0;
                    $course->save();
                    $res = array('status' => "200", "message" => "Hủy thành công");
                }

                $video->state = $request->state;
                $video->save();

                Helper::reSortIndexVideoOfCourse($course->id);

                echo json_encode($res);die;
            }
        }

        $res = array('status' => "401", "message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function deleteVideo(Request $request)
    {
        if ($request->video_id) {
            $video = Video::find($request->video_id);
            if ($video) {

                $unit = $video->unit;
                if($unit){
                    $course = $unit->course;
                    if($course){
                        if( $course->all_videos() == 1 ){
                            $course->status = 0;
                        }
                    }
                }

                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/360/'.$video->link_video);
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/480/'.$video->link_video);
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/720/'.$video->link_video);
                $path_video_origin = public_path('/uploads/videos/').$video->link_video;
                if( isset($video->link_video) ){
                    if(\File::exists($path_video_origin)){
                        unlink($path_video_origin);
                    }
                }

                $video->delete();

                $unit = $video->unit;
                if($unit){
                    $unit->video_count = $unit->video_count -1;
                    $unit->save();
                    $course = $unit->course;
                    if($course){
                        $course->video_count = $course->video_count -1;
                        if($course->all_videos() == 0){
                            $course->status = 0;
                        }
                        $course->save();
                    }
                }


                $res = array('status' => "200", "message" => "Xóa thành công");
                echo json_encode($res);die;
            }
        }
        $res = array('status' => "401", "message" => 'Không thành công.');
        echo json_encode($res);die;
    }

    public function getRequestDeleteVideo()
    {
        return view('backends.videos.request-delete-video');
    }

    public function getRequestDeleteVideoAjax()
    {
        $videos = Video::whereIn('state',[2])->get();
        return datatables()->collection($videos)
            ->addColumn('course_name', function ($video) {
                return $video->Unit->course->name;
            })
            ->addColumn('teacherName', function ($video) {
                if(isset($video->unit->course->Lecturers()->first()->user)){
                    return $video->unit->course->Lecturers()->first()->user->name;
                }
                return "";
            })
            ->addColumn('action', function ($video) {
                return $video->id;
            })
            ->addColumn('reject', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function rejectRequestDeleteVideo(Request $request)
    {
        $video = Video::find($request->video_id);
        if ($video) {
            if ( $video->state == Config::get('app.video_waiting_to_delete') ){
                $video->state       = Config::get('app.video_active');
                $video->updated_at  = date('Y-m-d H:i:s');
                $video->save();
                \App\Helper\Helper::addAlert($video->unit->course->Lecturers()[0]->user, "app.email_unaccept_request_delete_video");
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Đã hủy yêu cầu xóa bài giảng.',
                ]);
            }
        }
        return response()->json([
            'status' => 404,
            'message' => 'Thao tác không thành công.',
        ]);
    }

    public function acceptRequestDeleteVideo(Request $request)
    {
        $video = Video::find($request->video_id);
        if ($video) {
            if ( $video->state == Config::get('app.video_waiting_to_delete') ){

                // Sap xep lai user_courses->videos
                $unit = $video->unit;
                if ( $unit ){
                    $course = $unit->course;
                    if ( $course ){
                        $user_courses = $course->userCourses;
                        Helper::reBuildJsonWhenCreateOrDeleteLecture($course->id, $video->id, 0);
                        \App\Helper\Helper::addAlert($course->Lecturers()[0]->user, "app.email_accept_request_delete_video");
                    }
                }
                $video->state       = Config::get('app.video_in_trash');
                $video->updated_at  = date('Y-m-d H:i:s');
                $video->save();


                return response()->json([
                    'status' => 200,
                    'message' => 'Xóa bài giảng thành công.',
                ]);
            }
        }
        return response()->json([
            'status' => 404,
            'message' => 'Thao tác không thành công.',
        ]);
    }

    public function disable(Request $request){
        if($request->video_id){
            $video = Video::find($request->video_id);
            if($video){
                $video->state = \Config::get('app.video_waiting');
                $video->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Huỷ duyệt thành công'
                ]);
            }
        }
    }

    // Request Edit Video
    public function getRequestEditVideo()
    {
        return view('backends.videos.request-edit-video');
    }

    public function getRequestEditVideoAjax()
    {
        $videos = TempVideo::all();
        return datatables()->collection($videos)
            ->addColumn('course_name', function ($video) {
                return $video->Unit->course->name;
            })
            ->addColumn('teacherName', function ($video) {
                if(isset($video->unit->course->Lecturers()->first()->user)){
                    return $video->unit->course->Lecturers()->first()->user->name;
                }
                return "";
            })
            ->addColumn('action', function ($video) {
                return $video->id;
            })
            ->addColumn('reject', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function acceptEditVideo(Request $request)
    {
        $temp_video = TempVideo::find($request->temp_video_id);
        if ($temp_video) {
            $video = Video::find($temp_video->video_id);

            if ($video){

                $temp_documents = TempDocument::where('video_id', $temp_video->video_id)->get();
                if ( $temp_documents->count() > 0 ){
                    foreach ($temp_documents as $key => $temp_document) {
                        $document = new Document;
                        $document->title        = $temp_document->title;
                        $document->video_id     = $temp_document->video_id;
                        $document->url_document = $temp_document->url_document;
                        $document->size         = $temp_document->size;
                        $document->created_at   = $temp_document->created_at;

                        $document->save();
                        $temp_document->delete();
                    }
                }

                // if($temp_video->files_delete){
                //     $document_ids = explode(",", $temp_video->files_delete);
                //     foreach ($document_ids as $key => $id) {
                //         $document = Document::find($id);
                //         if($document){
                //             if (file_exists(public_path('uploads/files/'.$old->url_document))) {
                //                 unlink(public_path('uploads/files/'.$old->url_document));
                //             }
                //             $document->delete();
                //         }
                //     }
                // }

                if ($temp_video->link_video){
                    // convert video to multi resolution
                    $path_360 = "/usr/local/WowzaStreamingEngine-4.7.7/content/360/".$temp_video->link_video;
                    $path_480 = "/usr/local/WowzaStreamingEngine-4.7.7/content/480/".$temp_video->link_video;
                    $path_720 = "/usr/local/WowzaStreamingEngine-4.7.7/content/720/".$temp_video->link_video;
                    $path_1080 = "/usr/local/WowzaStreamingEngine-4.7.7/content/1080/".$temp_video->link_video;
        
                    $content_path_360 = "vod/_definst_/360/".$temp_video->link_video;
                    $content_path_480 = "vod/_definst_/480/".$temp_video->link_video;
                    $content_path_720 = "vod/_definst_/720/".$temp_video->link_video;
                    $content_path_1080 = "vod/_definst_/1080/".$temp_video->link_video;
        
                    $json = '{"360": "'.$content_path_360.'", "480": "'.$content_path_480.'", "720": "'.$content_path_720.'", "1080": "'.$content_path_1080.'"}';
                    // echo json_encode($json);die;
                    // $video->url_video = $json;
                    // $video->url_video = json_encode($json);
                    $temp_video->url_video = $json;
                    $temp_video->save();
                    
                    // $video->state      = 3;
                    $video->save();
                    // $temp_video->delete();
                    
                    dispatch(new ProcessLectureEdit($path_360, $temp_video->id, $request->video_id, $temp_video->link_video, 360));
                    dispatch(new ProcessLectureEdit($path_480, $temp_video->id, $request->video_id, $temp_video->link_video, 480));
                    dispatch(new ProcessLectureEdit($path_720, $temp_video->id, $request->video_id, $temp_video->link_video, 720));
                    dispatch(new ProcessLectureEdit1080($path_1080, $temp_video->id, $request->video_id, $temp_video->link_video, 1080));

                    return response()->json([
                        'status' => 200,
                        'message' => 'Bài giảng đã được sửa và đang được convert.',
                    ]);
                }else{
                    if($temp_video->files_delete){
                        $document_ids = explode(",", $temp_video->files_delete);
                        foreach ($document_ids as $key => $id) {
                            $document = Document::find($id);
                            if($document){
                                if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                                    unlink(public_path('uploads/files/'.$document->url_document));
                                }
                                $document->delete();
                            }
                        }
                    }

                    $video->name        = $temp_video->name;
                    $video->duration    = $temp_video->duration;
                    $video->description = $temp_video->description;
                    // $video->updated_at  = date('Y-m-d H:i:s');
                    $video->state = \Config::get('app.video_active');
                    $video->save();
                    $temp_video->delete();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Bài giảng đã được sửa.',
                    ]);
                }
    
            }
        }
        return response()->json([
            'status' => 404,
            'message' => 'Không thành công.',
        ]);
    }

    public function rejectEditVideo(Request $request)
    {
        $temp_video = TempVideo::find($request->temp_video_id);
        if ($temp_video) {

            // Delete temp_documents
            $documents = TempDocument::where('video_id', $temp_video->video_id)->get();
            if ( $documents->count() > 0 ){
                foreach ($documents as $key => $document) {
                    if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                        unlink(public_path('uploads/files/'.$document->url_document));
                    }
                    $document->delete();
                }
            }

            //Delete temp_videos
            if ( $temp_video->link_video ){
                if (file_exists(public_path('uploads/files/'.$temp_video->url_document))) {
                    unlink(public_path('uploads/videos/'.$temp_video->link_video));
                }
            }
            $temp_video->delete();
            $video = Video::find($temp_video->video_id);
            $video->state = Config::get('app.video_active');
            $video->save();

            \App\Helper\Helper::addAlert($video->unit->course->Lecturers()[0]->user, "app.email_unaccept_request_edit_video");

            return response()->json([
                'status' => 200,
                'message' => 'Đã hủy yêu cầu sửa bài giảng.',
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Thao tác không thành công.',
        ]);
    }
    

    public function getVideoInTrash()
    {
        return view('backends.videos.videos-in-trash');
    }

    public function getVideoInTrashAjax()
    {
        $videos = Video::where('state', 5)->get();
        return datatables()->collection($videos)
            ->addColumn('course_name', function ($video) {
                if ( $video->unit ){
                    if ( $video->unit->course ){
                        return $video->Unit->course->name;
                    }else{
                        return '';
                    }
                }else{
                    return '';
                }
            })
            ->addColumn('action', function ($video) {
                return $video->id;
            })
            ->addColumn('rows', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function deleteVideoInTrash(Request $request)
    {
        $video = Video::find($request->video_id);

        // Xoa documents
        $documents = Document::where('video_id', $video->id)->get();
        if ( $documents->count() > 0 ){
            foreach ($documents as $key => $document) {
                if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                    unlink(public_path('uploads/files/'.$document->url_document));
                }
                $document->delete();
            }
        }
        //Xoá luôn video
        $path_video = public_path('uploads/videos/'.$video->link_video);
        if(\File::exists($path_video)) {
            \File::delete($path_video);
        }
        exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/360/'.$video->link_video);
        exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/480/'.$video->link_video);
        exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/720/'.$video->link_video);

        $video->delete();
        return response()->json([
            'status' => '200',
            'message' => 'Xoá video bài giảng thành công.'
        ]);
    }

    public function deleteMultiVideoInTrash(Request $request)
    {
        $video_id_list = $request->video_id_list;
        foreach ($video_id_list as $key => $video_id) {
            $video = Video::find($video_id);
            if ( $video ){
                // Xoa documents
                $documents = Document::where('video_id', $video->id)->get();
                if ( $documents->count() > 0 ){
                    foreach ($documents as $key => $document) {
                        if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                            unlink(public_path('uploads/files/'.$document->url_document));
                        }
                        $document->delete();
                    }
                }
                //Xoá luôn video
                $path_video = public_path('uploads/videos/'.$video->link_video);
                if(\File::exists($path_video)) {
                    \File::delete($path_video);
                }
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/360/'.$video->link_video);
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/480/'.$video->link_video);
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/720/'.$video->link_video);

                $video->delete();
            }
        }
        return response()->json([
            'status' => '200',
            'message' => 'Xoá video bài giảng thành công.'
        ]);
    }

    public function getRequestAcceptVideo()
    {
        return view('backends.videos.request-accept-video');
    }

    public function getRequestAcceptVideoAjax()
    {
        $sql = "SELECT videos.id, videos.state, videos.name, videos.link_video, videos.updated_at, courses.name as course_name, courses.id as course_id, courses.slug as course_slug
        FROM videos
        JOIN units ON units.id = videos.unit_id
        JOIN courses ON courses.id = units.course_id
        WHERE videos.state = 0
        ";
        $videos = \DB::select($sql);
        return datatables()->collection(collect($videos))
            ->addColumn('action', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function deleteRequestAcceptVideo(Request $request)
    {
        $video = Video::find($request->video_id);
        if ($video) {
            if ( $video->state == 0 ){

                // Delete documents
                $documents = Document::where('video_id', $video->id)->get();
                if ( $documents->count() > 0 ){
                    foreach ($documents as $key => $document) {
                        if (file_exists(public_path('uploads/files/'.$document->url_document))) {
                            unlink(public_path('uploads/files/'.$document->url_document));
                        }
                        $document->delete();
                    }
                }

                // Delete Video
                if( isset($video->link_video) ){
                    $path_video_origin = public_path('/uploads/videos/').$video->link_video;
                    if(\File::exists($path_video_origin)){
                        unlink($path_video_origin);
                    }
                }
                
                // Resort UserCourse
                // $unit = $video->unit;
                // if ( $unit ){
                //     $course = $unit->course;
                //     if ( $course ){
                //         Helper::reBuildJsonWhenCreateOrDeleteLecture($course->id, $video->id, $flag = 0);
                //     }
                // }

                $video->delete();

                if($video->unit->course){
                    $course = $video->unit->course;
                    \App\Helper\Helper::addAlert($course->Lecturers()[0]->user, "app.email_inactive_video");
                }

                $res = array('status' => "200", "message" => "Xóa bài giảng thành công.");
                echo json_encode($res);die;
            }
        }
        $res = array('status' => "404", "message" => 'Thao tác không thành công.');
        echo json_encode($res);die;
    }
}
