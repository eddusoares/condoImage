<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\File;
use App\Models\Reviewer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Models\SupportTicket;
use App\Models\Tag;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReviewerController extends Controller
{

    public function dashboard()
    {
        $pageTitle = 'Dashboard';
        $reviewer_id = auth()->guard('reviewer')->user()->id;
        $totalPendings = File::where('status', 0)->count();
        $totalReviewing = File::where('reviewer_id', $reviewer_id)->where('status', 3)->count();
        $totalRejected = File::where('reviewer_id', $reviewer_id)->where('status', 2)->count();
        $totalPublished = File::where('reviewer_id', $reviewer_id)->where('status', 1)->count();
        $globalRejected = File::where('status', 2)->count();
        $globalPublished = File::where('status', 1)->count();
        $totalCategories = Category::where('status', 1)->count();
        $totalTags = Tag::where('status', 1)->count();
        $totalReviewers = Reviewer::count();
        return view('reviewer.dashboard', compact(
            'pageTitle',
            'totalPendings',
            'totalReviewing',
            'totalRejected',
            'totalPublished',
            'totalCategories',
            'totalTags',
            'totalReviewers',
            'globalRejected',
            'globalPublished'
        ));
    }


    public function profile()
    {
        $pageTitle = 'Profile';
        $reviewer = Reviewer::where('id', auth()->guard('reviewer')->user()->id)->first();
        return view('reviewer.profile', compact('pageTitle', 'reviewer'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $reviewer = auth()->guard('reviewer')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $reviewer->image;
                $reviewer->image = fileUploader($request->image, getFilePath('reviewerProfile'), getFileSize('reviewerProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $reviewer->name = $request->name;
        $reviewer->email = $request->email;
        $reviewer->save();
        $notify[] = ['success', 'Profile has been updated successfully'];
        return to_route('reviewer.profile')->withNotify($notify);
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $reviewer = auth()->guard('reviewer')->user();
        if (!Hash::check($request->old_password, $reviewer->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $reviewer->password = bcrypt($request->password);
        $reviewer->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('reviewer.profile')->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('admin.notifications', compact('pageTitle', 'notifications'));
    }
}
