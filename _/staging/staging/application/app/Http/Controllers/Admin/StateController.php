<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function index()
    {
        $pageTitle = 'All State';
        $states = State::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.state.index', compact('pageTitle', 'states'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
        ]);
        $state = new State();
        $state->name = $request->name;
        $state->status = isset($request->status) ? 1 : 0;
        $state->save();
        $notify[] = ['success', 'State has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
        ]);

        $state = State::findOrFail($id);
        $state->name = $request->name;
        $state->status = isset($request->stateStatus) ? 1 : 0;
        $state->save();
        $notify[] = ['success', 'State has been updated successfully'];
        return back()->withNotify($notify);
    }
}
