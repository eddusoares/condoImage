<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImageCategory;

class ImageCategoryController extends Controller
{
    public function index()
    {
       
        $pageTitle = 'All Image Category';
        $imageCategories = ImageCategory::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.image_category.index', compact('pageTitle', 'imageCategories'));
    }

    public function myList()
    {
        $pageTitle = 'My Categories';
        $myImageCategories = ImageCategory::where('userable_type', 'user')
            ->where('userable_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.image_category.my_list', compact('pageTitle','myImageCategories'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
               'name' => 'required|max:60|unique:image_categories,name',
        ]);
        $imageCategory = new ImageCategory();
        $imageCategory->name = $request->name;
        $imageCategory->userable_id = auth()->id();
        $imageCategory->userable_type = 'user';
        $imageCategory->save();
        $notify[] = ['success', 'Image category has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $imageCategory = ImageCategory::findOrFail($id);
        abort_unless($imageCategory->userable_type === 'user' && $imageCategory->userable_id === auth()->id(), 403, 'Unauthorized action.');
        $this->validate($request, [
            'name' => 'required|max:60|unique:image_categories,name,' . $imageCategory->id,
        ]);

        $imageCategory->name = $request->name;
        $imageCategory->userable_id = auth()->id();
        $imageCategory->userable_type = 'user';
        $imageCategory->save();
        $notify[] = ['success', 'Image category has been updated successfully'];
        return back()->withNotify($notify);
    }
}
