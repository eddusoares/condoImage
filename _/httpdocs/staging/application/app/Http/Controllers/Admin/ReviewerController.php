<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Reviewers';
        $reviewers = Reviewer::orderBy('id', 'desc')->paginate(getPaginate(10));
        return view('admin.reviewer.index', compact('pageTitle', 'reviewers'));
    }

    public function create(Request $request)
    {
        $pageTitle = 'Create New Reviewer';
        return view('admin.reviewer.create', compact('pageTitle'));
    }

    public function insert(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name' => 'required',
            'email' => 'required|unique:reviewers',
            'username' => 'required|unique:reviewers',
            'mobile' => 'required|unique:reviewers',
            'password' => 'required|confirmed',
        ]);

        if ($request->hasFile('image')) {
            try {
                $image = fileUploader($request->image, getFilePath('reviewerProfile'), getFileSize('reviewerProfile'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $reviewer = new Reviewer();
        $reviewer->name = $request->name;
        $reviewer->email = $request->email;
        $reviewer->username = $request->username;
        $reviewer->mobile = $request->mobile;
        $reviewer->password = bcrypt($request->password);
        $reviewer->image = $image;
        $reviewer->save();
        $notify[] = ['success', 'New Reviewer has been created successfully'];
        return to_route('admin.reviewer.index')->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Reviewer';
        $reviewer = Reviewer::findOrFail($id);
        return view('admin.reviewer.edit', compact('pageTitle', 'reviewer'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'mobile' => 'required',
        ]);

        $reviewer = Reviewer::findOrFail($id);

        if ($request->hasFile('image')) {
            try {
                $old = $reviewer->image;
                $image = fileUploader($request->image, getFilePath('reviewerProfile'), getFileSize('reviewerProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $reviewer->name = $request->name;
        $reviewer->email = $request->email;
        $reviewer->username = $request->username;
        $reviewer->mobile = $request->mobile;

        if (isset($request->password)) {
            $this->validate($request, [
                'password' => 'confirmed',
            ]);
            $reviewer->password = bcrypt($request->password);
        }

        if (isset($request->image)) {
            $reviewer->image = $image;
        }

        $reviewer->save();

        $notify[] = ['success', 'Reviewer data has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $reviewer = Reviewer::findOrFail($id);
        $imagePath = getFilePath('reviewerProfile');
        fileManager()->removeFile($imagePath . '/' . $reviewer->image);
        $reviewer->delete();
        $notify[] = ['success', 'Reviewer has been deleted successfully'];
        return back()->withNotify($notify);
    }
}
