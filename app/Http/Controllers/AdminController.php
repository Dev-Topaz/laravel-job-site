<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Countries;
use App\Models\NewsFeed;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Influencers;
use App\Models\InfluencerInfo;
use App\Models\Brands;
use App\Models\BrandInfo;
use App\Models\Requests;
use App\Models\RequestInfo;
use App\Models\Referral;
use App\Models\Profile;
use App\Models\Featured;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $influencers = Influencers::all();
        $brands = Brands::all();
        $giftedRequests = RequestInfo::where('gift', '=', 1)->get();
        $paidRequests = RequestInfo::where('gift', '=', 0)->get();
        if (count($giftedRequests) != 0 || count($paidRequests) != 0) {
            $gifted = floor(count($giftedRequests) / (count($giftedRequests) + count($paidRequests)) * 100);
        } else {
            $gifted = 0;
        }
        $paid = 100 - $gifted;
        $referrals = Referral::orderBy('created_at', 'desc')->limit(3)->get();
        foreach ($referrals as $referral) {
            $user = new User();
            $influencerInfo = $user->getAccountInfoByUserID($referral->user_id);
            $referral_userInfo = $user->getAccountInfoByUserID($referral->referral_user_id);
            $referral->influencerInfo = $influencerInfo[0];
            $referral->influencerProfile = Profile::where('user_id', '=', $referral->user_id)->first();
            $referral->referral_userInfo = $referral_userInfo[0];
            $referral->influencerProfile = Profile::where('user_id', '=', $referral->referral_user_id)->first();
        }

        return view('admin.dashboard', [
            'user_count' => count($users),
            'influencer_count' => count($influencers),
            'brand_count' => count($brands),
            'gifted' => $gifted,
            'paid' => $paid,
            'referrals' => $referrals,
            'page' => 1
        ]);
    }

    public function news()
    {
        return view('admin.news', [
            'page' => 3,
        ]);
    }

    public function saveNews(Request $request)
    {
        $input = $request->all();

        $message = [
            'full_name.required' => "Please enter the name",
            'full_name.regex' => "Name can contain only letters and spaces.",
            'title.required' => "Please enter the project title",
            'title.regex' => "Project title can contain only letters and spaces.",
            'description.required' => "Please enter the description",
            'back_img' => 'Please select the image',
            'logo_img' => "Please select the image",
        ];

        $rule = [
            'full_name' => 'required|string|max:255|regex:/(^([a-zA-Z ]+)?$)/',
            'title' => 'required|string|max:255|regex:/(^([a-zA-Z0-9 ]+)?$)/',
            'description' => 'required|string',
            'back_img' => 'required',
            'logo_img' => 'required'
        ];

        $validator = Validator::make($input, $rule, $message);
        if ($validator->fails()) {
            return redirect()->route('news')
                ->withErrors($validator)
                ->withInput($input);
        }

        $newsFeed = new NewsFeed;
        $newsFeed->full_name = $input['full_name'];
        $newsFeed->project_title = $input['title'];
        $newsFeed->description = $input['description'];

        $filename = time() . "_" . uniqid();
        $disk = Storage::disk("local");
        $disk->put('/news-image/' . $filename . '.jpg', file_get_contents($input['back_img']));
        $newsFeed->back_img = $filename;

        $filename = time() . "_" . uniqid();
        $disk = Storage::disk("local");
        $disk->put('/news-image/' . $filename . '.jpg', file_get_contents($input['logo_img']));
        $newsFeed->logo_img = $filename;

        if ($newsFeed->save())
            return redirect()->route('news')->with('msg', "News feed is published successfully");
        else
            return redirect()->route('news')->with('msg', "DB error! Please try again.");
    }

    public function users(Request $request)
    {
        $countries = Countries::all();
        $allCategories = Category::all();

        $input = $request->all();
        $name = (isset($input['name'])) ? $input['name'] : '';
        $category = (isset($input['categories'])) ? $input['categories'] : '';
        $location = (isset($input['location'])) ? $input['location'] : '';
        $accountType = (isset($input['accountType'])) ? $input['accountType'] : 'influencer';
        $keyword = (isset($input['keyword'])) ? $input['keyword'] : '';
        $perPage = (isset($input['perPage'])) ? $input['perPage'] : 8;

        if ($name == '' && $category == '' && $location == '' && $keyword == '') {
            $results = [];
            return view('admin.search', [
                'accountType' => $accountType,
                'users' => $results,
                'countries' => $countries,
                'categories' => $allCategories,
                'page' => 2,
            ]);
        }

        if ($accountType == 'brand') {
            $brands = new Brands();
            $results = $brands->getUsers($name, $category, $location, $keyword, $perPage);
        } else {
            $influencers = new Influencers();
            $results = $influencers->getUsers($name, $category, $location, $keyword, $perPage);
        }

        return view('admin.search', [
            'accountType' => $accountType,
            'users' => $results,
            'countries' => $countries,
            'categories' => $allCategories,
            'page' => 2,
        ]);
    }

    public function projects(Request $request)
    {
        $input = $request->all();
        $keyword = (isset($input['keyword'])) ? $input['keyword'] : '';
        $requests = new Requests();
        $projects = $requests->getAllRequests($keyword);

        return view('admin.projects', [
            'page' => 4,
            'projects' => $projects,
            'keyword' => $keyword,
        ]);
    }

    public function referrals()
    {
        $signUps = User::all()->count();
        $referral = new Referral();
        $referrals = $referral->getAllReferrals();

        return view('admin.referrals', [
            'signUps' => $signUps,
            'referrals' => $referrals,
            'page' => 5,
        ]);
    }

    public function calcelReferral()
    {
        $referrals = $_GET['checked'];
        foreach ($referrals as $referral) {
            $referral = Referral::find($referral);
            $referral->active = 0;
            $referral->save();
        }
        return redirect()->route('adminReferrals');
    }

    public function extras()
    {
        return view('admin.extras', [
            'page' => 6
        ]);
    }

    public function submitAdminReview(Request $request)
    {
        $input = $request->all();
        $rule = [
            'username' => 'required|string|regex:/(^([a-zA-Z ]+)?$)/',
            'project_title' => 'required|string|regex:/(^([a-zA-Z0-9 ]+)?$)/',
            'review' => 'required|string',
            'brand_name' => 'required|string|regex:/(^([a-zA-Z ]+)?$)/',
            'date' => 'required'
        ];
        $message = [
            'username.required' => 'Please enter an influencer name.',
            'username.regex' => 'Username can contains only letters and space.',
            'project_title.required' => 'Please enter the project title.',
            'project_title.regex' => "Project title can contains only letters, numbers and space.",
            'brand_name.required' => "Please enter a brand name.",
            'brand_name.regex' => 'Brand name can contains only letters and space.',
            'review.required' => "Please enter the review details.",
            'date.required' => "Please select the date",
        ];
        $validator = Validator::make($input, $rule, $message);
        if ($validator->fails()) {
            return redirect()->route('extras')
                ->withErrors($validator)
                ->withInput($input);
        }

        $influencer = User::where('username', '=', $input['username'])->get();
        if(count($influencer) > 0)
            $influencer = $influencer[0]->id;
        else
            return redirect()->route('extras')->with('msg', "Influencer not exists.");

        $brand = User::where('username', '=', $input['brand_name'])->get();
        if(count($brand) > 0)
            $brand = $brand[0]->id;
        else
            return redirect()->route('extras')->with('msg', "Brand not exists.");

        $requests = new Requests;
        $requests->send_id = $brand;
        $requests->receive_id = $influencer;
        $requests->created_at = $input['date'];
        $requests->save();

        $review = new Review;
        $review->request_id = $requests->id;
        $review->user_id = $influencer;
        $review->review = $input['review'];
        $review->star = $input['totalRating'];
        $review->save();

        $reviews = Review::where('user_id', '=', $influencer)->get();
        $totalRating = 0;
        $reviewCount = 0;
        if(count($reviews) > 0) {
            $reviewCount = count($reviews);
            foreach($reviews as $review){
                echo $review->star;
                echo ', ';
                $totalRating += $review->star;
            }
        }

        $influencer_id = Influencers::where('user_id', '=', $influencer)->first()->id;
        $influencerInfo = InfluencerInfo::where('influencer_id', '=', $influencer_id)->first();
        $influencerInfo->reviews = $reviewCount;
        $influencerInfo->rating = $totalRating / $reviewCount;

        if (
            $influencerInfo->save()
        ) {
            echo $totalRating;
            die;

            return redirect()->route('extras')->with('msg', "New review saved successfully!");
        }
        else
            return redirect()->route('extras')->with('msg', "DB error, please try again");
    }

    function verifyUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

        return redirect()->route('users')->with('msg', 'now in DEV');
    }

    function featureUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

        $featured = Featured::where('user_id', '=', $user_id)->first();
        if($featured) {
            return redirect()->route('users')->with('msg', 'Already Featured');
        }

        $featured = new Featured;
        $featured->user_id = $user_id;
        
        if($featured->save()) {
            return redirect()->route('users')->with('msg', 'Successful');
        } else {
            return redirect()->route('users')->with('msg', 'DB error');
        }
    }

    function deleteUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];
        
        $user = User::find($user_id);
        if($user->delete()) {
            return redirect()->route('users')->with('msg', 'Successful');
        } else {
            return redirect()->route('users')->with('msg', 'DB error');
        }
    }

    function blockUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];
        
    }
}
