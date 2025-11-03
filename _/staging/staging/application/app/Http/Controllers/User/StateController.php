<?php

namespace App\Http\Controllers\User;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function index()
    {
        $pageTitle = 'All State';
        $states = State::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.state.index', compact('pageTitle', 'states'));
    }


    public function myList()
    {
        $pageTitle = 'My Categories';
        $myStates = State::where('userable_type', 'user') 
        ->where('userable_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.state.my_list', compact('pageTitle', 'myStates'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
        ]);
        $state = new State();
        $state->name = $request->name;
        $state->userable_id = auth()->id();
        $state->userable_type = 'user';
        $state->status = isset($request->status) ? 1 : 0;
        $state->save();
        $notify[] = ['success', 'State has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $state = State::findOrFail($id);

        abort_unless($state->userable_type === 'user' && $state->userable_id === auth()->id(), 403, 'Unauthorized action.');

        $this->validate($request, [
            'name' => 'required|max:60',
        ]);

        $state->name = $request->name;
        $state->userable_id = auth()->id();
        $state->userable_type = 'user';
        $state->status = isset($request->stateStatus) ? 1 : 0;
        $state->save();
        $notify[] = ['success', 'State has been updated successfully'];
        return back()->withNotify($notify);
    }
}
