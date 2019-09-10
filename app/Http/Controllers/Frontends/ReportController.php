<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Report;
use Auth;

class ReportController extends Controller
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
    public function store(StoreReportRequest $request)
    {
        if(isset($request->message)){
            $report = new Report;
            $report->user_id = Auth::id();
            $report->title = $request->title;
            $report->video_id = $request->videoId;
            $report->message = $request->message;

            $report->save();
            return \Response::json(array('status' => '200', 'message' => 'Gửi báo lỗi thành công!'));

        }else{
            return \Response::json(array('status' => '404', 'message' => 'Gửi báo lỗi thất bại!'));
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
