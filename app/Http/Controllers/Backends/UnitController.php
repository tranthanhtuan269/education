<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Transformers\UnitTransformer;
use App\Course;
use App\Unit;
use App\Video;

class UnitController extends Controller
{
    public function getVideo($id){
        $video = Video::find($id);
        return \Response::json(array('status' => '200', 'message' => 'List Videos!', 'video' => $video));
    }

    public function getVideos($id){
        $videos = Video::where('unit_id', $id)
                ->whereIn('state',[0,1])
                ->orderBy('index', 'asc')
                ->get()
                ->toArray();
        // echo '<pre>';
        // print_r($videos);die;
        return \Response::json(array('status' => '200', 'message' => 'List Videos!', 'videos' => $videos));
    }

    public function store(StoreUnitRequest $request){
        $course = Course::withCount('units')->find($request->course_id);
        if($course){
            $unit = new Unit;
            $unit->name = $request->name;
            $unit->course_id = $course->id;
            $unit->index = $course->units_count + 1;

            $user_roles = $course->userRoles()->where('role_id', 3)->get();
            foreach ($user_roles as $key => $user_role) {
                $user_course = \App\UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                $videos = json_decode($user_course->videos);
                $video_arr = $videos->{"videos"};
                array_push($video_arr, []);
                $videos->{"videos"} = $video_arr;
                $videos = json_encode($videos);
                $user_course->videos = $videos;
                $user_course->save();
            }

            $unit->save();

            return \Response::json(array('status' => '200', 'message' => 'Tạo Unit thành công!', 'unit' => fractal($unit, new UnitTransformer())->toArray()));
        }
        return \Response::json(array('status' => '404', 'message' => 'Tạo Unit không thành công!'));
    }

    public function updateVideo(Request $request, $id){
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
            return \Response::json(array('status' => '200', 'message' => 'Sửa Video thành công!', 'video' => $video));
        }
        return \Response::json(array('status' => '404', 'message' => 'Sửa Video không thành công!'));
    }

    public function update(UpdateUnitRequest $request, $id){
        $unit = Unit::find($id);
        if($unit){
            $unit->name = $request->name;
            $unit->save();
            return \Response::json(array('status' => '200', 'message' => 'Sửa Unit thành công!', 'unit' => fractal($unit, new UnitTransformer())->toArray()));
        }
        return \Response::json(array('status' => '404', 'message' => 'Sửa Unit không thành công!'));
    }

    public function sort(Request $request){
        if($request->data){
            $list = json_decode($request->data);
            foreach($list as $obj){
                $unit = Unit::find($obj->id);
                if($unit){
                    $unit->index = $obj->index;
                    $unit->save();
                }
            }

            $course = $unit->course;
            $user_roles = $course->userRoles()->where('role_id', 3)->get();
            foreach($user_roles as $key => $user_role){
                $user_course = \App\UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                $videos = json_decode($user_course->videos);                
                \App\Helper\Helper::moveElementInArray($videos, $request->old_pos, $request->new_pos);
                $videos = json_encode($videos);
                $user_course->videos = $videos;
                $user_course->save();
            }

            return \Response::json(array('status' => '200', 'message' => 'Sửa Unit thành công!'));
        }
        return \Response::json(array('status' => '404', 'message' => 'Sửa Unit không thành công!'));
    }

    public function sortVideo(Request $request){
        if($request->sorted_list){
            $sorted_list = json_decode($request->sorted_list);
            $unit = Unit::find($request->unit_id);
            $unit_videos = $unit->videos->sortBy('index');
            $unit_videos_index = $unit_videos->pluck('index')->toArray();
            $min_index = reset($unit_videos_index);
            $max_index = end($unit_videos_index);

            $new_sorting_list = [];
            $k = 0;
            for ($i= $min_index; $i <= $max_index ; $i++) { 
                array_push($new_sorting_list, [$i => $sorted_list[$k]->id]);
                $k++;
            }

            foreach ($new_sorting_list as $key => $video_id) {
                $video = Video::find($video_id)->first();
                $video->index = $key;
                $video->save();
            }
            
            return response()->json([
                'status' => '200',
                'message' => 'Sửa thứ tự video thành công'
            ]);
        }
    }

    public function destroy(Request $request){
        $unit = Unit::find($request->id);
        if($unit){
            // BaTV - Xoá tất cả video với các định dạng trong Unit đó
            $arr_video_id = Video::where('unit_id', $request->id)->pluck('id')->toArray();
            $arr_video = Video::where('unit_id', $request->id)->pluck('url_video');

            if (count($arr_video) > 0) {
                foreach ($arr_video as $path) {

                    $json_video = json_decode($path, true);

                    if (count($json_video) > 0) {
                        foreach ($json_video as $path_video) {
                            if(\File::exists($path_video)) {
                                \File::delete($path_video);
                            }
                        }
                    }

                }

                Video::whereIn('id', $arr_video_id)->delete();
            }
            //DuongNT // Xoá array đại diện cho unit này trong array video của user_course đại diện mõi student
            $course = $unit->course;
            $user_roles = $course->userRoles()->where('role_id', 3)->get();
            foreach ($user_roles as $key => $user_role) {
                $user_course = \App\UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                $videos = json_decode($user_course->videos);
                $video_arr = $videos->{"videos"};
                array_splice($video_arr, $unit->index-1, 1);
                $videos->{"videos"} = $video_arr;
                $videos = json_encode($videos);
                $user_course->videos = $videos;
                $user_course->save();
            }

            $unit->delete();
            return \Response::json(array('status' => '200', 'message' => 'Xóa Unit thành công!'));
        }
    }
}
