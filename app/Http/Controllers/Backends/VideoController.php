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

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendRemoveVideoRequest(Request $request)
    {
        $video = Video::find($request->video_id);

        if ($video) {
            if($video->state == 2){ //Đang được admin duyệt
                return response()->json([
	                'status' => '201',
	                'message' => 'Yêu cầu xoá video đang được duyệt!'
	            ]);
            }
            if($video->state!=-1){
                $unit = $video->unit;
                // $unit->video_count -= 1;
                // $unit->save();

                $course = $unit->course;
                // $course->video_count -= 1;
                // $course->save();
                
                $video->state = 2; //Đang được admin duyệt
                $video->save();



	            $json_video = json_decode($video->url_video, true);

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

	            return response()->json([
	                'status' => '200',
	                'message' => 'Yêu cầu xoá video đã được gửi!'
	            ]);
            }else{
                return response()->json([
                    'status' => '404',
                    'message' => 'Yêu cầu xoá video không được gửi thành công!',
                ]);
            }
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
            $video->state = 3;
            $video->save();
            
            // DuongNT // thêm 1 video vào lượng đã xem vào bảng user_courses
            $unit = $video->unit;
            $course = $unit->course;
            $user_roles = $course->userRoles()->where('role_id', 3)->get()->all();//lấy những user_role đại diện student
            #Insert cho từng student
            
            foreach ($user_roles as $key => $user_role) {
                $user_course = UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                $videos = json_decode($user_course->videos);
                array_push($videos->{'videos'}[($unit->index) - 1 ], 0);
                $videos = json_encode($videos);
                $user_course->videos = $videos;
                $user_course->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Video is verified!',
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Video is not found!',
        ]);
    }

    // Verify Video
    public function getVideo()
    {
        return view('backends.videos.video');
    }

    public function getVideoAjax()
    {
        // $videos = Video::get();
        $videos = Video::whereIn('state',[0,1,3])->get();
        return datatables()->collection($videos)
            ->addColumn('course_name', function ($video) {
                return $video->Unit->course->name;
            })
            // ->addColumn('teacherName', function ($video) {
            //     return $video->unit->course->Lecturers()->first()->user->name;
            // })
            ->addColumn('action', function ($video) {
                return $video->id;
            })
        // ->addColumn('rows', function ($video) {
        //     return $video->id;
        // })
            ->removeColumn('id')->make(true);
    }

    public function accept(Request $request)
    {
        if ($request->video_id != null) {
            $video = Video::find($request->video_id);

            if ($video) {
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
                    
                    dispatch(new ProcessLecture($path_720, $request->video_id, $video->link_video, 720));
                    dispatch(new ProcessLecture($path_480, $request->video_id, $video->link_video, 480));
                    dispatch(new ProcessLecture($path_360, $request->video_id, $video->link_video, 360));

                    $res = array('status' => "200", "message" => "Duyệt thành công");
                } else {
                    // BaTV - Nếu hủy bất kỳ video nào trong khóa học đó =>  Khóa học tương ứng sẽ hủy theo
                    $course = $video->unit->course;
                    $course->status = 0;
                    $course->save();
                    $res = array('status' => "200", "message" => "Hủy thành công");
                }

                $video->state = $request->state;
                $video->save();
                
                echo json_encode($res);die;
            }
        }

        $res = array('status' => "401", "message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function acceptMultiVideo(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Video::acceptMulti($id_list, 1)) {
                $res = array('status' => 200, "message" => "Đã duyệt hết");
            } else {
                $res = array('status' => "204", "message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function inacceptMultiVideo(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Video::acceptMulti($id_list, 0)) {
                $res = array('status' => 200, "message" => "Đã hủy hết");
            } else {
                $res = array('status' => "204", "message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function deleteVideo(Request $request)
    {
        if ($request->video_id) {
            $video = Video::find($request->video_id);
            if ($video) {
                // $json_video = json_decode($video->url_video, true);

                // if (count($json_video) > 0) {
                //     foreach ($json_video as $path_video) {
                //         if(\File::exists($path_video)) {
                //             \File::delete($path_video);
                //         }
                //     }
                // }
                // echo 'rm /usr/local/WowzaStreamingEngine-4.7.7/content/360/'.$video->link_video;die;
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/360/'.$video->link_video);
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/480/'.$video->link_video);
                exec('rm /usr/local/WowzaStreamingEngine-4.7.7/content/720/'.$video->link_video);

                $path_video_origin = public_path('/uploads/videos/').$video->link_video;
                if(\File::exists($path_video_origin)){
                    unlink($path_video_origin);
                }    

                $video->delete();
                $res = array('status' => "200", "message" => "Xóa thành công");
                echo json_encode($res);die;
            }
        }
        $res = array('status' => "401", "message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function deleteMultiVideo(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Video::delMulti($id_list)) {
                $res = array('status' => 200, "message" => "Đã xóa hết");
            } else {
                $res = array('status' => "204", "message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function testVideo(){
        $video = Video::find(1);

        $path_360 = "/usr/local/WowzaStreamingEngine-4.7.7/content/360/".$video->link_video;

        // dispatch(new ProcessLecture($path_360, $video->id, $video->link_video, 360));
        ProcessLecture::dispatch($path_360, $video->id, $video->link_video, 360);

        return response()->json([
            'message'=>'done'
        ]);
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
                return $video->unit->course->Lecturers()->first()->user->name;
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
        // echo 1;die;
        $video = Video::find($request->video_id);
        if ($video) {
            $video->state       = 1;
            $video->updated_at  = date('Y-m-d H:i:s');
            $video->save();

            return response()->json([
                'status' => 200,
                'message' => 'Đã hủy yêu cầu xóa Video!',
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Video is not found!',
        ]);
    }
}
