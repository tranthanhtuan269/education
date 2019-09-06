<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreNoteRequest;
use App\Note;
use App\Video;
use App\Transformers\NoteTransformer;
use App\Helper\Helper;
use Auth;

class NoteController extends Controller
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
     */
    public function store(StoreNoteRequest $request)
    {
        //
        $video = Video::find($request->videoId);
        
        if($video){
            $note = new Note;
            $note->content = $request->content;
            $note->video_id = $request->videoId;
            $note->user_id = Auth::id();
            $note->time_tick = $request->timeTick;

            $note->save();

            return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'note' => fractal($note, new NoteTransformer())->toArray()));
            
        }else{
            return \Response::json(array('status' => '404', 'message' => 'Course Id không tồn tại!'));
        }
        

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
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
