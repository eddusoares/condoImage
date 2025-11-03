<?php

namespace App\Http\Controllers\User;

use App\Models\County;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class NeighborhoodController extends Controller
{
    public function index()
    {
        $pageTitle = 'All County';
        $neighborhoods = Neighborhood::with('county')->orderBy('id', 'desc')->paginate(getPaginate(20));
        $counties = County::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.neighborhood.index', compact('pageTitle', 'neighborhoods','counties'));
    }

    public function myList()
    {
        $pageTitle = 'My Categories';
        $counties = County::orderBy('id', 'desc')->paginate(getPaginate(20));
        $myNeighborhoods = Neighborhood::where('userable_type', 'user')
            ->where('userable_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.neighborhood.my_list', compact('pageTitle', 'counties','myNeighborhoods'));
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'county_id' => 'required|integer',
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $neighborhood = new Neighborhood();
        $neighborhood->name = $request->name;
        $neighborhood->userable_id = auth()->id();
        $neighborhood->userable_type = 'user';
        $neighborhood->county_id = $request->county_id;
        $neighborhood->status = isset($request->status) ? 1 : 0;
        if ($request->hasFile('image')) {
            try {
                $neighborhood->image = fileUploader($request->image, getFilePath('neighborhood'), getFileSize('neighborhood'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $neighborhood->save();
        $notify[] = ['success', 'NeighborHood has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $neighborhood = Neighborhood::findOrFail($id);
        abort_unless($neighborhood->userable_type === 'user' && $neighborhood->userable_id === auth()->id(), 403, 'Unauthorized action.');

        $this->validate($request, [
            'name' => 'required|max:60',
            'county_id' => 'required|integer',
        ]);
        $neighborhood->name = $request->name;
        $neighborhood->county_id = $request->county_id;
        $neighborhood->status = isset($request->neighborhoodStatus) ? 1 : 0;
        $neighborhood->userable_id = auth()->id();
        $neighborhood->userable_type = 'user';

        if ($request->hasFile('image')) {
            try {
                $old = $neighborhood->image;
                $neighborhood->image = fileUploader($request->image, getFilePath('neighborhood'), getFileSize('neighborhood'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $neighborhood->save();
        $notify[] = ['success', 'NeighborHood has been updated successfully'];
        return back()->withNotify($notify);
    }
}
