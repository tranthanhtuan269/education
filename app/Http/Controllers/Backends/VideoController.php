<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoRequest;
use App\Transformers\VideoTransformer;
use App\Unit;
use App\Video;

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
        if($unit){
            $video = new Video;
            $video->name    = $request->name;
            $video->unit_id = $request->unit_id;
            $video->description = $request->description;
            $video->index   = $unit->videos_count;
            $video->description = $request->description;
            $video->url_video = json_encode(['a'=>'b']);

            if ($request->link_video != '') {
                $link_video = $request->link_video.'.mp4';
                $video->link_video = $link_video;
                $command = config('config.path_ffprobe_exe').' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 '.public_path("/uploads/videos/").$link_video.' 2>&1';
                $video->duration =  exec($command, $output, $return);
            }
            
            $video->save();

            return response()->json([
                'status' => '200',
                'message' => 'New video is created!',
                'video' => fractal($video, new VideoTransformer())->toArray(),
            ]);
        }

        return response()->json([
            'status' => '404',
            'message' => 'Cannot create new video! There was a problem!'
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $video = Video::find($request->video_id);

        if($video){
            $video->delete();

            return response()->json([
                'status' => '200',
                'message' => 'Delete video successfully!'
            ]);
        }
    }

    public function sort(Request $request){
        if($request->data){
            $list = json_decode($request->data);
            foreach($list as $obj){
                $video = Video::find($obj->id);
                if($video){
                    $video->index = $obj->index;
                    $video->save();
                }
            }
            return \Response::json(array('status' => '200', 'message' => 'Sửa Video thành công!'));
        }
        return \Response::json(array('status' => '404', 'message' => 'Sửa Video không thành công!'));
    }

    public function verifyVideo(){
        $myvideo = Video::find(12);
        return view('backends.videos.verify',[
            'myvideo' => $myvideo
        ]);
    }

    public function getUnverifiedVideoAjax (){
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

    public function acceptVideo ( Request $request ){
        $video = Video::find($request->video_id);
        if($video){
            $video->state = 1;
            $video->save();

            return response()->json([
                'status' => 200,
                'message' => 'Video is verified!'
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Video is not found!'
        ]);
    }

    // Verify Video
    public function getVideo(){
        return view('backends.videos.video');
    }

    public function getVideoAjax()
    {
        $videos = Video::get();
        return datatables()->collection($videos)
            ->addColumn('course_name', function ($video) {
                return $video->Unit->course->name;
            })
            ->addColumn('action', function ($video) {
                return $video->id;
            })
            ->addColumn('rows', function ($video) {
                return $video->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function accept(Request $request)
    {
        if($request->video_id){
            $video = Video::find($request->video_id);
            if($video){
                $video->state = $request->state;
                $video->save();
                if($request->state == 1){
                    $res = array('status' => "200", "Message" => "Duyệt thành công");
                }else{
                    $res = array('status' => "200", "Message" => "Hủy thành công");
                }
                echo json_encode($res);die;
            }
        }
        $res = array('status' => "401", "Message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function acceptMultiVideo(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Video::acceptMulti($id_list, 1)) {
                $res = array('status' => 200, "Message" => "Đã duyệt hết");
            } else {
                $res = array('status' => "204", "Message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function inacceptMultiVideo(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Video::acceptMulti($id_list, 0)) {
                $res = array('status' => 200, "Message" => "Đã hủy hết");
            } else {
                $res = array('status' => "204", "Message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function deleteVideo(Request $request)
    {
        if($request->video_id){
            $video = Video::find($request->video_id);
            if($video){
                $video->delete();
                $res = array('status' => "200", "Message" => "Xóa thành công");
                echo json_encode($res);die;
            }
        }
        $res = array('status' => "401", "Message" => 'Người dùng không tồn tại.');
        echo json_encode($res);die;
    }

    public function deleteMultiVideo(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');

            if (Video::delMulti($id_list)) {
                $res = array('status' => 200, "Message" => "Đã xóa hết");
            } else {
                $res = array('status' => "204", "Message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }
}
