<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Agent;
use App\Models\BonusManage;
use App\Models\Currency;
use App\Models\Referral;
use App\Models\Wallet;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $pageTitle = 'User Dashboard';
        $emptyMessage = 'No active user found';
        // User Info
        $widget['balance'] = User::where('id', '=', auth()->user()->id)->sum('balance');
        $widget['sendMoney'] = Transaction::where('user_id', '=', auth()->user()->id)->where('trx_type', '=', '-')->sum('amount');
        $widget['cashOut'] = Transaction::where('user_id', '=', auth()->user()->id)->where('trx_type', '=', '+')->sum('amount');
        $widget['transactions'] = Transaction::orderBy('id', 'desc')->where('user_id', '=', auth()->user()->id)->paginate(getPaginate(10));
        $widget['verified_users'] = User::where('status', 1)->count();
        $widget['email_unverified_users'] = User::where('ev', 0)->count();
        $widget['sms_unverified_users'] = User::where('sv', 0)->count();
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'emptyMessage', 'widget'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required' => 'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status', 1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate . 'user.withdraw.methods', compact('pageTitle', 'withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id', 'desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle', 'withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id', 'desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg', 'jpeg', 'png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user, $request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['withdraw']['path'] . '/' . $directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        $emptyMessage  = "No Data Found!";
        return view($this->activeTemplate . 'user.withdraw.log', compact('pageTitle', 'withdraws',  'emptyMessage'));
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
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
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
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
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }
    public function referralLink()
    {
        $pageTitle = 'Referral Link';
        $emptyMessage = "";
        //https://localhost/tcash/register/kingBoy
        return view($this->activeTemplate . 'user.auth.referral_link', compact('pageTitle', 'emptyMessage'));
    }
    public function sendMoneyForm()
    {
        $pageTitle = 'Send Money';
        return view($this->activeTemplate . 'user.send_money', compact('pageTitle'));
    }
    public function sendMoneyStore(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'amount' => 'required|numeric|gt:0'
            ],
            [
                'username.required' => 'Select your receiver!',
                'amount.required' => 'Please give your amount'
            ]
        );
        $moneyCharge = BonusManage::first();
        $chrgAmount = $request->amount * $moneyCharge->send_money_charge / 100;
        //Sender
        $sender = User::findOrFail(auth()->user()->id);
        $currency = Currency::where('currency', $request->currency)->first();
        $senderCheck = Wallet::where('user_id', $sender->id)->where('currency_id', $currency->id)->first();
        if ($senderCheck == null) {
            $notify[] = ['error', 'Your Currency invalid.'];
            return back()->withNotify($notify);
        }
        $TotalCutBalance = $chrgAmount + $request->amount;
        if ($senderCheck->balance <  $TotalCutBalance) {
            $notify[] = ['error', 'Insufficient Transaction Balance.'];
            return back()->withNotify($notify);
        }
        $senderCheck->balance -= $TotalCutBalance;
        //Receiver//
        $user = User::where('status', 1)->where('username', $request->username)->first();
        if (!$user) {
            $notify[] = ['error', 'Username not found, Please try again!'];
            return back()->withNotify($notify);
        }
        $currency = Currency::where('currency', $request->currency)->first();
        $userQueryCheck = Wallet::where('user_id', $user->id)->where('currency_id', $currency->id)->first();
        // dd( $userQueryCheck);
        if (!$userQueryCheck) {
            $createUserWallet = new Wallet();
            $createUserWallet->user_id = $userQueryCheck->id;
            $createUserWallet->currency_id = $currency->id;
            $createUserWallet->balance = $request->amount;
            // dd($createUserWallet);
            $createUserWallet->save();
        }
        $userQueryCheck->balance += $request->amount;
        $senderCheck->save(); //sender
        $userQueryCheck->save(); //receiver
        //SenderUserTransaction//
        $transactionSender =  new Transaction;
        $transactionSender->user_id =  $sender->id;
        $transactionSender->amount = $request->amount;
        $transactionSender->trx_type = '-';
        $transactionSender->currency = $request->currency;
        $transactionSender->post_balance = $senderCheck->balance;
        $transactionSender->trx = getTrx();
        $transactionSender->details = 'Send Money Via ' . $request->currency;
        $transactionSender->save();

        ///ReceiverUserTransaction
        $transactionReceiver =  new Transaction;
        $transactionReceiver->user_id =  $user->id; //id
        $transactionReceiver->amount = $request->amount;
        $transactionReceiver->trx_type = '+';
        $transactionReceiver->currency = $request->currency;
        $transactionReceiver->post_balance = $userQueryCheck->balance;
        $transactionReceiver->trx = $transactionSender->trx;
        $transactionReceiver->details = 'Send Money Via ' . $request->currency;
        $transactionReceiver->save();

        //Referral-for-send-money//
        $getReferral = Auth::user();
        if ($getReferral->ref_by != 0) {
            $referralWallet = Wallet::where('user_id', $getReferral->ref_by)->where('currency_id', $currency->id)->latest()->first();
            $referrals = Referral::where('commission_type', 'send-money')->first();
            $referralCharge = $referrals->fixed_charge + ($request->amount * $referrals->percentage / 100);
            if (!$referralWallet) {
                $referralBalance = new Wallet();
                $referralBalance->user_id = $getReferral->ref_by;
                $referralBalance->currency_id = $currency->id;
                $referralBalance->balance = $referralCharge;
                $referralWallet = $referralBalance;
            }
            $referralWallet->balance += $referralCharge;
            $referralWallet->save();
            // // Referral Send Money Charge Transaction log Create//
            $transaction = new Transaction();
            $transaction->user_id = $getReferral->ref_by;
            $transaction->amount = $referralCharge;
            $transaction->currency = $currency->currency;
            $transaction->post_balance = $referralWallet->balance;
            $transaction->charge = $referralCharge;
            $transaction->trx_type = '+';
            $transaction->details = 'Referral send money bonus transaction';
            $transaction->trx = $transactionSender->trx;
            // dd($transaction);
            $transaction->save();
        }

        $notify[] = ['success', 'Transaction successfully Completed.'];
        return back()->withNotify($notify);
    }

    public function cashOutForm()
    {
        $pageTitle = 'Cash Out';
        $agent = Agent::get();
        return view($this->activeTemplate . 'user.cash_out', compact('pageTitle', 'agent'));
    }
    public function cashOutStore(Request $request)
    {
        $request->validate(
            [
                'agent_id' => 'required|integer|gt:0',
                'amount' => 'required|numeric|gt:0'
            ],
            [
                'agent_id.required' => 'Select your desire Agent.',
                'amount.required' => 'Please give your amount.'
            ]
        );

        $bManage = BonusManage::first();
        $totalDeductForUser = $bManage->fixed_charge + ($request->amount * $bManage->cash_out_commission / 100);
        $finalCutBalance = $totalDeductForUser + $request->amount;
        $user = auth()->user();
        if ($user->balance < $finalCutBalance) {
            $notify[] = ['error', 'Insufficient Transaction Balance.'];
            return back()->withNotify($notify);
        }
        $user->balance -= $totalDeductForUser + $request->amount;
        $user->save();
        $agent = Agent::findOrFail($request->agent_id); //Receiver id
        $agent->balance +=  ($totalDeductForUser + $request->amount);
        $agent->save();
        //Sender-UserTransaction//
        $transactionUser =  new Transaction;
        $transactionUser->user_id =  $user->id;
        $transactionUser->amount = $request->amount;
        $transactionUser->trx_type = '-';
        $transactionUser->trx = getTrx();
        $transactionUser->details = 'Cash Out Via ' . $request->currency;
        $transactionUser->save();

        ///Receiver-AgentTransaction
        $transactionUser =  new Transaction;
        $transactionUser->agent_id = $agent->id; //id
        $transactionUser->amount = $request->amount;
        $transactionUser->trx_type = '+';
        $transactionUser->trx = getTrx();
        $transactionUser->details = 'Cash Out Via ' . $request->currency;
        $transactionUser->save();

        $notify[] = ['success', 'Transaction successfully Completed.'];
        return back()->withNotify($notify);
    }
}
