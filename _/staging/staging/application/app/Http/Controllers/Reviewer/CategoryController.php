<?php

namespace App\Http\Controllers\Reviewer;

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
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $category = new Category();
        $category->name = $request->name;
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
        $this->validate($request, [
            'name' => 'required|max:60',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
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
