<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $categories = Category::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.category.index', compact('pageTitle', 'categories'));
    }

    public function myList()
    {
        $pageTitle = 'My Categories';
        $myCategories = Category::where('userable_type', 'user') 
        ->where('userable_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.category.my_list', compact('pageTitle', 'myCategories'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60|unique:categories,name',
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->userable_id = auth()->id();
        $category->userable_type = 'user';
        $category->status = isset($request->status) ? 1 : 0;

        if ($request->hasFile('image')) {
            try {
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $category->save();
        $notify[] = ['success', 'Category has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        abort_unless($category->userable_type === 'user' && $category->userable_id === auth()->id(), 403, 'Unauthorized action.');

        $this->validate($request, [
            'name' => 'required|string|max:60|unique:categories,name,'. $category->id,
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        $category->name = $request->name;
        $category->userable_id = auth()->id();
        $category->userable_type = 'user';
        $category->status = isset($request->catstatus) ? 1 : 0;

        if ($request->hasFile('image')) {
            try {
                $old = $category->image;
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $category->save();
        $notify[] = ['success', 'Category has been updated successfully'];
        return back()->withNotify($notify);
    }
}
