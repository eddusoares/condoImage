<?php

namespace App\Http\Controllers\User;

use ZipArchive;
use Carbon\Carbon;
use App\Models\File;
use App\Models\Form;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\Building;
use App\Models\Wishlist;
use App\Lib\FormProcessor;
use App\Models\Withdrawal;
use App\Models\ListingUnit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $general = gs();
        $mainBalance = $user->balance;
        $totalDeposits = Deposit::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $totalWithdrawals = Withdrawal::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $pendingDepositsCount = Deposit::where('user_id', $user->id)->where('status', 2)->count();
        $pendingWithdrawalsCount = Withdrawal::where('user_id', $user->id)->where('status', 2)->count();
        $totalBuildings =  Building::where('status', 1)->count();


        $withdrawalsReport = Withdrawal::selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
            ->whereYear('created_at', date('Y'))
            ->where('user_id', auth()->id())
            ->whereStatus(1)
            ->groupBy('month_name', 'month_num')
            ->orderBy('month_num')
            ->get();
        $withdrawalsChart['labels'] = $withdrawalsReport->pluck('month_name');
        $withdrawalsChart['values'] = $withdrawalsReport->pluck('amount');

        $deposits = Deposit::selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
            ->where('user_id', auth()->id())
            ->where('payment_type', 1)
            ->whereYear('created_at', date('Y'))
            ->whereStatus(1)
            ->groupBy('month_name', 'month_num')
            ->orderBy('month_num')
            ->get();
        $depositsChart['labels'] = $deposits->pluck('month_name');
        $depositsChart['values'] = $deposits->pluck('amount');



        $color = $general->base_color;

        return view($this->activeTemplate . 'user.dashboard', compact(
            'pageTitle',
            'mainBalance',
            'totalDeposits',
            'totalWithdrawals',
            'pendingDepositsCount',
            'pendingWithdrawalsCount',
            'withdrawalsChart',
            'depositsChart',
            'totalBuildings',
            'color',
        ));
    }

    public function myOrder()
    {
     
        $pageTitle = 'My Orders';
        $orders = Order::with('buildingListingUnit', 'building.neighborhood.county')->where('status', 1)->where('user_id', auth()->id())->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'orders'));
    }

    public function myWishlist()
    {
        $pageTitle = 'My Wishlist';
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.wishlist.index', compact('pageTitle', 'wishlists'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->user_type == 2 && auth()->user()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->user_type == 2 && auth()->user()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function download($id)
    {
        $user = auth()->user();
        $order = Order::with('building', 'buildingListingUnit')->where('status', 1)->where('user_id', auth()->id())->where('id', $id)->first();
        if (!$order) {
            $notify[] = ['error', 'You do not have permission to download this image bundle'];
            return to_route('user.order')->withNotify($notify);
        }
        if ($user->user_type == 2) {
            $notify[] = ['error', 'The contributor does not have permission to perform this action'];
            return to_route('user.order')->withNotify($notify);
        }

        if ($order->building_type == 1) {
            $building = Building::with('buildingImages')->where('id', $order->building_id)->first();

            if ($building->buildingImages->isEmpty()) {
                $notify[] = ['error', 'No images found for this building.'];
                return to_route('user.order')->withNotify($notify);
            }

            $imageLocation = getFilePath('building');

            $zipFilePath =  $this->compressFilesFromRequest($imageLocation, $building->buildingImages);

            // Download the zip file
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            $listingUnit = ListingUnit::with('listingImages')->where('id', $order->listing_unit_id)->first();

            if ($listingUnit->listingImages->isEmpty()) {
                $notify[] = ['error', 'No images found.'];
                return to_route('user.order')->withNotify($notify);
            }

            $imageLocation = getFilePath('listing_asset_image');
            $zipFilePath =  $this->compressFilesFromRequest($imageLocation, $listingUnit->listingImages);

            // Download the zip file
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        }
    }
    public function compressFilesFromRequest($imageLocation, $images)
    {

        $zipFileName = 'building_images_' . getTrx() . '.zip';
        $zipDir = getFilePath('zip_image_bundle');
        $destination = $zipDir . $zipFileName;

        // Make sure directory exists
        if (!file_exists($zipDir)) {
            mkdir($zipDir, 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($destination, ZipArchive::CREATE) === true) {

            // Iterate over each uploaded file
            foreach ($images as $image) {
                // Add the file to the ZIP archive
                $imagePath =  $imageLocation . '/' . $image->image; // Adjust if you store differently
                if (file_exists($imagePath)) {
                    $zip->addFile($imagePath, basename($imagePath));
                };
            }
            $zip->close();
            return $destination; // Compression successful
        }
        return false; // Failed to create ZIP file
    }
}
