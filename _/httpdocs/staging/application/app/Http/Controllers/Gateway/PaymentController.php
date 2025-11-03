<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Building;
use App\Models\Deposit;
use App\Models\File;
use App\Models\GatewayCurrency;
use App\Models\ListingUnit;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $file = File::where('status', 1)->find($request->file_id);
        $pageTitle = 'Payment';
        $payment = $request->payment;
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        if ($payment == 1) {
            return view($this->activeTemplate . 'user.payment.payment', compact('gatewayCurrency', 'pageTitle', 'file', 'payment'));
        }
        if ($payment == 2) {
            return view($this->activeTemplate . 'user.payment.payment', compact('gatewayCurrency', 'pageTitle', 'payment'));
        }
    }

    public function condoBuildingPayment(Request $request)
    {
        $user = auth()->user();
        if ($user->user_type == 2) {
            $notify[] = ['error', 'Contributor is not buying condo building'];
            return back()->withNotify($notify);
        }


        $building = Building::findOrFail($request->condo_building_id);
        $pageTitle = 'Condo Building Payment';
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return view($this->activeTemplate . 'user.payment.condo_building_payment', compact('gatewayCurrency', 'pageTitle', 'building'));
    }

    public function condoListingPayment(Request $request)
    {

        $user = auth()->user();
        if ($user->user_type == 2) {
            $notify[] = ['error', 'Contributor is not buying condo building'];
            return back()->withNotify($notify);
        }

        $ListingUnit = ListingUnit::findOrFail($request->condo_listing_id);

        $pageTitle = 'Condo Listing Payment';
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return view($this->activeTemplate . 'user.payment.condo_listing_payment', compact('gatewayCurrency', 'pageTitle', 'ListingUnit'));
    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required_unless:gateway,balance',
            'currency' => 'required_unless:gateway,balance',
            'gateway' => 'required',
        ]);


        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;


        // deposit table add data
        $data = new Deposit();
        $data->user_id = $user->id;
        $data->payment_type = 1;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function condoDepositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required_unless:gateway,balance',
            'currency' => 'required_unless:gateway,balance',
            'building_type' => 'required|in:1,2',
            'building_id' => 'required_if:building_type,1|numeric|gt:0',
            'listing_unit_id' => 'required_if:building_type,2',
        ]);

        $amount = 0;
        if ($request->building_id) {
            $building = Building::with('neighborhood','neighborhood.county')->where('status', 1)->where('id', $request->building_id)->first();

            $amount = $building->price;
        }

        if ($request->listing_unit_id) {
            $listingUnit = ListingUnit::where('id', $request->listing_unit_id)->first();
            $amount = $listingUnit->price;
        }

        if ($request->gateway == 'balance') {
            if ($request->amount > auth()->user()->balance) {
                $notify[] = ['error', 'Sorry, You don\'t have sufficient balance.'];
                // return redirect()->route('condo.building.details', $request->building_id)->withNotify($notify);

                return redirect()->route('condo.building.details', ['county' => slug($building->neighborhood->county->name),'neighborhood' => slug($building->neighborhood->name),'slug' => slug($building->name), 'id' => $building->id])->withNotify($notify);
            }
            return $this->payWithBalance($request, $amount);
        }



        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable = $amount + $charge;
        $final_amo = $payable * $gate->rate;



        // order table add data
        $order = new Order();
        $order->user_id = $user->id;
        $order->building_id = $request->building_id ?? 0;
        $order->listing_unit_id = $request->listing_unit_id ?? 0;
        $order->building_type = $request->building_type;
        $order->amount = $amount;
        $order->status = 0; // initial
        $order->save();


        // deposit table add data
        $data = new Deposit();
        $data->user_id = $user->id;
        $data->order_id = $order->id;
        $data->payment_type = 2;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $order->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', 0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {
        // deposit find
        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();
            $general = gs();

            $user = User::find($deposit->user_id);
            // check deposit with order or user balance add

            if ($deposit->order_id != 0) {
                //order find
                $order = Order::find($deposit->order_id);
                $order->status = 1;
                $order->save();

                // check buying order unit number or building 
                if ($order->listing_unit_id) {
                    $listingUnit = ListingUnit::with('userable')->where('id', $order->listing_unit_id)->first();
                    if ($listingUnit && $listingUnit->userable_type == 'user' && $listingUnit->userable) {

                        $listing_commission = $general->listing_commission;
                        $commissionAmount = ($order->amount * $listing_commission) / 100;

                        $listingUnit->userable->balance += $commissionAmount;
                        $listingUnit->userable->save();
                    }
                } else {

                    $building = Building::where('id', $order->building_id)->first();
                    if ($building && $building->claim == 2 && $building->claim_by != 0) {

                        $user = User::where('id', $building->claim_by)->first();
                        $building_commission = $general->building_commission; // example: 5
                        $commissionAmount = ($order->amount * $building_commission) / 100;
                        $user->balance += $commissionAmount;
                        $user->save();
                    }
                }
            } else {
                $user->balance += $deposit->amount;
                $user->save();
            }

            $message = (($deposit->payment_type == 1) ? 'Deposit' : 'Payment ');
            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = $message . $deposit->gatewayCurrency()->name;
            $transaction->trx = $deposit->trx;
            $transaction->remark = ($deposit->payment_type == 1) ? 'balance' : 'payment';
            $transaction->save();

            if (!$isManual) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = $message . 'successful via ' . $deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }


            if ($deposit->order_id != 0) {
                notify($user, $isManual ? 'PAYMENT_APPROVE' : 'PAYMENT_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance)
                ]);
            } else {
                notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance)
                ]);
            }
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {

        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);


        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();

        if ($data->order_id != 0) {
            $order = Order::find($data->order_id);
            $order->status = 2; // pending
            $order->save();
        }

        $message = (($data->payment_type == 1) ? 'Deposit' : 'Payment ');

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = $message . 'request from ' . $data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'rate' => showAmount($data->rate),
            'trx' => $data->trx
        ]);



        $notify[] = ['success', 'Your ' . $message . ' request has been taken'];
        return to_route('user.deposit.history')->withNotify($notify);
    }

    public function payWithBalance(Request $request, $amount)
    {

        if ($request->building_id) {
            $building = Building::with('neighborhood','neighborhood.county')->where('status', 1)->where('id', $request->building_id)->first();
        }

        if ($request->listing_unit_id) {
            $listingUnit = ListingUnit::where('id', $request->listing_unit_id)->first();
        }

        $user = auth()->user();
        $user->balance -= $amount;
        $user->save();

        $general = gs();

        $order = new Order();
        $order->user_id = $user->id; 
        $order->building_id = $request->building_id ?? 0;
        $order->listing_unit_id = $request->listing_unit_id ?? 0;
        $order->building_type = $request->building_type;
        $order->amount = $amount;
        $order->status = 1;
        $order->save();

        // check buying order unit number or building 
        if ($order->listing_unit_id) {
            $listingUnit = ListingUnit::with('userable')->where('id', $order->listing_unit_id)->first();
            if ($listingUnit && $listingUnit->userable_type === 'user' && $listingUnit->userable) {

                $listing_commission = $general->listing_commission;
                $commissionAmount = ($order->amount * $listing_commission) / 100;

                $listingUnit->userable->balance += $commissionAmount;
                $listingUnit->userable->save();
            }
        } else {

            $building = Building::with('neighborhood','neighborhood.county')->where('id', $order->building_id)->first();
            if ($building && $building->claim == 2 && $building->claim_by != 0) {

                $user = User::where('id', $building->claim_by)->first();
                $building_commission = $general->building_commission;
                $commissionAmount = ($order->amount * $building_commission) / 100;

                $user->balance += $commissionAmount;
                $user->save();
            }
        }

        if ($request->building_id) {
            $notify[] = ['success', 'You have successfully purchased condo building.'];
            // return redirect()->route('condo.building.details', $request->building_id)->withNotify($notify);
            return redirect()->route('condo.building.details', ['county' => slug($building->neighborhood->county->name),'neighborhood' => slug($building->neighborhood->name),'slug' => slug($building->name), 'id' => $building->id])->withNotify($notify);
        }

        if ($request->listing_unit_id) {
            $notify[] = ['success', 'You have successfully purchased condo building listing.'];
            return redirect()->route('condo.building.listing.images', ['slug' => slug($listingUnit->unit_number), 'id' => $listingUnit->id])->withNotify($notify);
        }
    }
}
