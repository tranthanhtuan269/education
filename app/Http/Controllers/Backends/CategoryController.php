<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Controllers\Backends\Requests\StoreCategoryRequest;

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
        $category->image        = $file_name;;
        $category->save();

        return \Response::json(array('status' => '200', 'Message' => 'Thêm mới danh mục thành công!'));
    }
}
