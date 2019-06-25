<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Transformers\UnitTransformer;
use App\Course;
use App\Unit;

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

    public function destroy(Request $request){
        $unit = Unit::find($request->id);
        if($unit){
            $unit->delete();
            return \Response::json(array('status' => '200', 'message' => 'Xóa Unit thành công!'));
        }
    }
}
