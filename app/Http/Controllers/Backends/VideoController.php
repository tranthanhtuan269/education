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
}
