<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\NewsFeed;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index(Request $request)
  {
    $page = 1;
    $account = new User();
    $accountInfo = $account->getAccountInfoByUserID(Auth::user()->id);

    $profile = new Profile();
    $portfolios = $profile->getPortfolios(Auth::user()->id);

    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

    if (Auth::user()->stripe_id != '') {
      $account_info = $stripe->accounts->retrieve(
        Auth::user()->stripe_id,
        []
      );
      // echo $account_info;
    }
    $url = '';

        if (isset($account_info->details_submitted) && $account_info->details_submitted
            && isset($account_info->charges_enabled) && $account_info->charges_enabled) {
          $url = '';
        } else {
          if ($accountInfo[0]->accountType == 'influencer')
            $url = "https://connect.stripe.com/express/oauth/authorize?suggested_capabilities[]=card_payments&response_type=code&client_id=". env('CUSTOMER_ID') ."&stripe_user[business_type]=individual&stripe_user[email]=" . Auth::user()->email;
        }

    if (isset($_GET['code'])) {
      $authorization_code = $_GET['code'];
      $response = $stripe->oauth->token([
        'grant_type' => 'authorization_code',
        'code' => $_GET['code'],
      ]);

      if (!isset($response->error)) {
        $stripe_id = $response->stripe_user_id;
        $user = User::find(Auth::user()->id);
        $user->stripe_id = $stripe_id;
        $user->save();

        $account_info = $stripe->accounts->retrieve(
          $stripe_id,
          []
        );

       // echo $account_info;

        if (isset($account_info->details_submitted) && $account_info->details_submitted
            && isset($account_info->charges_enabled) && $account_info->charges_enabled) {
          $url = '';
        } else {
          if ($accountInfo[0]->accountType == 'influencer')
            $url = "https://connect.stripe.com/express/oauth/authorize?suggested_capabilities[]=card_payments&response_type=code&client_id=". env('CUSTOMER_ID') ."&stripe_user[business_type]=individual&stripe_user[email]=" . Auth::user()->email;
        }
      }
    }

    $newsFeeds = NewsFeed::all();

    $unread = $request->get('unread');

    return view('home', [
      'newsFeeds' => $newsFeeds,
      'unread' => $unread,
      'portfolios' => $portfolios,
      'accountType' => $accountInfo[0]->accountType,
      'accountInfo' => $accountInfo[0],
      'page' => $page,
      'url' => $url,
    ]);
  }

  public function dashboard()
  {
    $page = 5;
    $account = new User();
    $accountInfo = $account->getAccountInfoByUserID(Auth::user()->id);

    return view('dashboard', [
      'accountType' => $accountInfo[0]->accountType,
      'accountInfo' => $accountInfo[0],
      'page' => $page,
    ]);
  }

  public function logOut()
  {
    $user = User::find(Auth::user()->id);
    $user->loggedIn = 0;
    $user->save();

    return response()->json([
      'data' => 'success',
    ]);
  }

  public function accountSetting(Request $request)
  {
    return view('accountSetting', [
      'page' => 5,
      'unread' => $request->get('unread'),
    ]);
  }

  public function updateAccount(Request $request)
  {
    $input = $request->all();
    $rule = [
      // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'curPassword' => ['required', 'string', 'min:8'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];
    $message = [
      'newPassword.confirmed' => 'Password not match',
    ];

    $validator = Validator::make($input, $rule);
    if ($validator->fails()) {
      return redirect('accountSetting')
        ->withErrors($validator)
        ->withInput($input);
    }

    $curPassword = $input['curPassword'];
    $newPassword = $input['password'];

    $password = Auth::user()->password;

    if (Hash::check($curPassword, $password)) {
      $user = User::find(Auth::user()->id);
      $user->password = Hash::make($newPassword);
      $user->save();
      return redirect('home');
    } else {
      return redirect('accountSetting')
        ->withErrors($validator)
        ->withInput($input);
    }
  }

  public function deleteAccount()
  {
    $user = User::find(Auth::user()->id);
    $user->delete();

    return redirect('home');
  }

  public function blog(Request $request, $news_id)
  {
    $news = NewsFeed::find($news_id);

    return view('blog', [
      'unread' => $request->get('unread'),
      'news' => $news,
      'page' => 1,
    ]);
  }
}
