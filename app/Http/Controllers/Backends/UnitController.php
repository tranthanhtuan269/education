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
    public function store(StoreUnitRequest $request){
        $course = Course::withCount('units')->find($request->course_id);
        if($course){
            $unit = new Unit;
            $unit->name = $request->name;
            $unit->course_id = $course->id;
            $unit->index = $course->units_count;
            $unit->save();

            return \Response::json(array('status' => '200', 'message' => 'Tạo Unit thành công!', 'unit' => fractal($unit, new UnitTransformer())->toArray()));
        }
        return \Response::json(array('status' => '404', 'message' => 'Tạo Unit không thành công!'));
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
            $unit->delete();
            return \Response::json(array('status' => '200', 'message' => 'Xóa Unit thành công!'));
        }
    }
}