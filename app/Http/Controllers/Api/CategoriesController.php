<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    public function index()
    {
        // 获取所有分类
        CategoryResource::wrap('data');

        return CategoryResource::collection(Category::all());
    }
}
