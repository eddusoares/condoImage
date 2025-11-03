<?php

namespace App\Http\Controllers\User;

use App\Models\State;
use App\Models\County;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
    public function index()
    {
        $pageTitle = 'All County';
        $counties = County::with('state')->orderBy('id', 'desc')->paginate(getPaginate(20));
        $states = State::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.county.index', compact('pageTitle', 'counties', 'states'));
    }


    public function myList()
    {
        $pageTitle = 'My Categories';
        $states = State::orderBy('id', 'desc')->paginate(getPaginate(20));
        $myCounties = County::with('state')->where('userable_type', 'user')
            ->where('userable_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.county.my_list', compact('pageTitle', 'myCounties','states'));
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'state_id' => 'required|integer',
        ]);
        $county = new County();
        $county->name = $request->name;
        $county->userable_id = auth()->id();
        $county->userable_type = 'user';
        $county->state_id = $request->state_id;
        $county->status = isset($request->status) ? 1 : 0;
         if ($request->hasFile('image')) {
            try {
                $county->image = fileUploader($request->image, getFilePath('county'), getFileSize('county'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $county->save();
        $notify[] = ['success', 'County has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
     
        $county = County::findOrFail($id);
        abort_unless($county->userable_type === 'user' && $county->userable_id === auth()->id(), 403, 'Unauthorized action.');

        $this->validate($request, [
            'name' => 'required|max:60',
            'state_id' => 'required|integer',
        ]);

        $county->name = $request->name;
        $county->userable_id = auth()->id();
        $county->userable_type = 'user';
        $county->state_id = $request->state_id;
        $county->status = isset($request->countyStatus) ? 1 : 0;
           if ($request->hasFile('image')) {
            try {
                $old = $county->image;
                $county->image = fileUploader($request->image, getFilePath('county'), getFileSize('county'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $county->save();
        $notify[] = ['success', 'County has been updated successfully'];
        return back()->withNotify($notify);
    }
}
