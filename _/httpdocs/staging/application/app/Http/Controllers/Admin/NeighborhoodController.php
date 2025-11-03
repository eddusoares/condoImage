<?php

namespace App\Http\Controllers\Admin;

use App\Models\County;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class NeighborhoodController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Neighborhood';
        $neighborhoods = Neighborhood::with('county')->orderBy('id', 'desc')->paginate(getPaginate(20));
        $counties = County::orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.neighborhood.index', compact('pageTitle', 'neighborhoods','counties'));
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
        $this->validate($request, [
            'name' => 'required|max:60',
            'county_id' => 'required|integer',
        ]);

        $neighborhood = Neighborhood::findOrFail($id);
        $neighborhood->name = $request->name;
        $neighborhood->county_id = $request->county_id;
        $neighborhood->status = isset($request->neighborhoodStatus) ? 1 : 0;

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
