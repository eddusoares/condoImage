<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\File;
use App\Models\Reviewer;
use App\Models\Tag;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Photos';
        $files = File::where('status', 0)->where('reviewer_id', null)->with(['user', 'category'])->paginate(getPaginate());
        return view('admin.review.index', compact('pageTitle', 'files'));
    }

    public function allReviewer()
    {
        $pageTitle = 'All Reviewers';
        $reviewers = Reviewer::paginate(getPaginate());
        return view('reviewer.reviewer.index', compact('pageTitle', 'reviewers'));
    }

    public function allCategories()
    {
        $pageTitle = 'All Categories';
        $categories = Category::where('status', 1)->paginate(getPaginate());
        return view('reviewer.category.index', compact('pageTitle', 'categories'));
    }

    public function allTags()
    {
        $pageTitle = 'All Tags';
        $tags = Tag::where('status', 1)->paginate(getPaginate());
        return view('reviewer.tag.list', compact('pageTitle', 'tags'));
    }

    public function view($id)
    {
        $pageTitle = 'Reviewer';
        $reviewer = Reviewer::findOrFail($id);
        return view('reviewer.reviewer.view', compact('pageTitle', 'reviewer'));
    }

    public function detail($id)
    {
        $pageTitle = 'Image Details';
        $file = File::findOrFail($id);
        if (isset($file->reviewer_id)) {
            $notify[] = ['warning', 'Somone else reviewing it.'];
            return back()->withNotify($notify);
        }
        $categories = Category::where('status', 1)->get();
        return view('admin.review.detail', compact('pageTitle', 'file', 'categories'));
    }

    public function detailAfterHandle($id)
    {
        $pageTitle = 'Image Details';
        $file = File::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.review.detail', compact('pageTitle', 'file', 'categories'));
    }

    public function onReviewing()
    {
        $pageTitle = 'On Reviewing by Admin';
        $files = File::where('status', 3)->where('reviewer_id', 0)->with(['user', 'category'])->orderBy('updated_at', 'desc')->paginate(getPaginate());
        return view('admin.review.index', compact('pageTitle', 'files'));
    }

    public function published()
    {
        $pageTitle = 'Published Files by Admin';
        $files = File::where('status', 1)->where('reviewer_id', 0)->with(['user', 'category'])->orderBy('updated_at', 'desc')->paginate(getPaginate());
        return view('admin.review.index', compact('pageTitle', 'files'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Files by Admin';
        $files = File::where('status', 2)->where('reviewer_id', 0)->with(['user', 'category'])->orderBy('updated_at', 'desc')->paginate(getPaginate());
        return view('admin.review.index', compact('pageTitle', 'files'));
    }

    public function changeHandleStatus(Request $request)
    {
        $file = File::findOrFail($request->file_id);
        if (isset($request->progress)) {
            $file->reviewer_id = 0;
            $file->status = 3;
        } else {
            $file->reviewer_id = null;
            $file->status = 0;
        }

        $file->save();
        $file->reviewer_name = isset($file->reviewer->name) ? $file->reviewer->name : '';

        return $file;
    }

    public function update(Request $request, $id)
    {
        $file = File::findOrFail($id);
        if ($request->status == 2) {
            $this->validate($request, [
                'reason' => 'required',
            ], [
                'reason.required' => 'Please provide rejection reason.',
            ]);

            $file->status = 2;
            $file->reason = $request->reason;
            $file->save();
            return $file;
        }

        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'status' => 'required'
        ], [
            'status.required' => 'Please enter a status.',
            'title.required' => 'Please enter a title.',
            'category_id.required' => 'Please select a category.',
            'tags.required' => 'Please select desired tags.',
            'description.required' => 'Please enter a description.',
        ]);


        $file->title = $request->title;
        $file->category_id = $request->category_id;
        $file->tags =  $request->tags;
        $file->description =  $request->description;
        $file->status = $request->status;
        $file->save();
        return $file;
    }
}
