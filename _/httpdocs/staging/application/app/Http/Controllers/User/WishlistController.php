<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist(Request $request)
    {
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('data_id', $request->id)->where('type', $request->type)->first();
            if ($wishlist) {
                $wishlist->delete();
                return ['status' => false];
            } else {
                $setNew = new Wishlist();
                $setNew->user_id = auth()->user()->id;
                $setNew->data_id = $request->id;
                $setNew->type = $request->type;
                $setNew->save();
                return ['status' => true];
            }
        } else {
            return ['auth' => false];
        }
    }
    public function wishlistDelete($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();
        $notify[] = ['success', 'Wishlist delete successfully'];
        return back()->withNotify($notify);
    }
}
