<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Category;
use App\Course;
use App\Http\Controllers\Backends\Requests\StoreCategoryRequest;
use App\Http\Controllers\Backends\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function getCategory()
    {
        $categories = Category::where('parent_id',0)->get();
        
        return view('backends.category.category',['categories'=>$categories]);
    }

    public function getCategoryAjax()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return datatables()->collection($categories)
            ->addColumn('action', function ($category) {
                return $category->id;
            })
            ->addColumn('parent-id', function ($category) {
                return $category->parent['id'];
            })
            ->addColumn('parent-name', function ($category) {
                return $category->parent['name'];
            })
            ->addColumn('rows', function ($category) {
                return $category->id;
            })
            ->removeColumn('id')->make(true);

    }

    public function addCategory(StoreCategoryRequest $request)
    {
        if ($request->image != '') {
            $img_file = $request->image;
            $img_file = base64_decode($img_file);
            $file_name = time() . '.png';
            file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
        }

        $category = new Category;
        $category->name         = $request->name;
        $category->parent_id    = $request->parent_id;
        $category->featured     = $request->featured;
        $category->icon         = $request->icon;
        // $category->slug         = \Str::slug($request->name, '-');
        $category->image        = $file_name;
        $res = array('status' => 200, "Message" => "Đã hủy hết");

        $category->save();

        return \Response::json(array('status' => '200', 'Message' => 'Thêm mới danh mục thành công!'));
    }

    public function editCategory(UpdateCategoryRequest $request)
    {
        $category = Category::find($request->id);
        if( $category ){
            if( $category->name != $request->name ){
                $check = Category::where('name', $request->name);
                if( $check ){
                    return \Response::json(array('status' => '403', 'Message' => 'Tên Danh mục đã tồn tại.'));
                }
            }

            $category->name         = $request->name;
            $category->parent_id    = $request->parent_id;
            $category->featured     = $request->featured;
            $category->icon         = $request->icon;
            // $category->image        = $file_name;
            $category->save();
    
            return \Response::json(array('status' => '200', 'Message' => 'Sửa Danh mục thành công!'));
        }
        return \Response::json(array('status' => '404', 'Message' => 'Danh mục không tồn tại.'));
    }

    public function deleteCategory(Request $request){
        $category = Category::where('parent_id', '=', $request->category_id)->update(['parent_id'=>1]);

        $course = Course::where('category_id', '=', $request->category_id)->update(['category_id'=>1]);

        $category1 = Category::find($request->category_id);
        if($category1){
            $category1->delete();
            $res = array('status' => "200", "message" => "Xóa Danh mục thành công!");
            echo json_encode($res);die;
        }
    }
}
