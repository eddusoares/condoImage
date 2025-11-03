<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImageCategory;

class ImageCategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Image Category';
        $imageCategories = ImageCategory::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.image_category.index', compact('pageTitle', 'imageCategories'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
               'name' => 'required|max:60|unique:image_categories,name',
        ]);
        $imageCategory = new ImageCategory();
        $imageCategory->name = $request->name;
        $imageCategory->save();
        $notify[] = ['success', 'Image category has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $imageCategory = ImageCategory::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:60|unique:image_categories,name,' . $imageCategory->id,
        ]);

        $imageCategory->name = $request->name;
        $imageCategory->save();
        $notify[] = ['success', 'Image category has been updated successfully'];
        return back()->withNotify($notify);
    }
}
