<?php

namespace App\Http\Controllers\Admin;

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
        $states = State::where('status',1)->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.county.index', compact('pageTitle', 'counties', 'states'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'state_id' => 'required|integer',
        ]);
        $county = new County();
        $county->name = $request->name;
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
        $this->validate($request, [
            'name' => 'required|max:60',
            'state_id' => 'required|integer',
        ]);

        $county = County::findOrFail($id);
        $county->name = $request->name;
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
