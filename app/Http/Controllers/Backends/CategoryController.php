<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function getCategory()
    {
        return view('backends.category.category');
    }

    public function getCategoryAjax()
    {
        $categories = Category::orderBy('name', 'desc')->get();
        return datatables();
    }
}
