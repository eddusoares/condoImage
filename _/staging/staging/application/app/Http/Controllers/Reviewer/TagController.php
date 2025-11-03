<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
        $pageTitle = 'Manage Tags';
        $tags = Tag::latest()->paginate(getPaginate());
        return view('admin.tag.list',compact('tags','pageTitle'));
    }


    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:255|unique:tags',
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->status = 1;
        $tag->save();

        $notify[] = ['success', 'Tag has been created successfully.'];
        return back()->withNotify($notify);

    }

    public function update(Request $request){
        $tag = Tag::find($request->id);
        $tag->name = $request->name;
        $tag->status = $request->status;
        $tag->save();

        $notify[] = ['success', 'Tag has been updated successfully.'];
        return back()->withNotify($notify);

    }
}
