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
            $video->name    = $request->name." ".$unit->videos_count;
            $video->unit_id = $request->unit_id;
            $video->index   = $unit->videos_count;
            $video->url_video = json_encode(['a'=>'b']);
            $video->duration = 100;
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
}
