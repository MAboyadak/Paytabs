<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetSubCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('categories.index', compact('categories'));
    }

    public function getSubcategories(GetSubCategoriesRequest $request)
    {
        $categoryId = $request->input('category_id');
        $subcategories = Category::where('parent_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}
