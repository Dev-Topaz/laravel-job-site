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
            return redirect()->back()
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
            return redirect()->back()->with('msg', "News feed is published successfully");
        else
            return redirect()->back()->with('msg', "DB error! Please try again.");
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
        $perPage = (isset($input['perPage'])) ? $input['perPage'] : 10;

        if ($name == '' && $category == '' && $location == '' && $keyword == '') {
            $results = [];
            return view('admin.search', [
                'selectedCategory' => $category,
                'selectedLocation' => $location,
                'selectedName' => $name,
                'selectedKeyword' => $keyword,
                'selectedPerpage' => $perPage,
                'accountType' => $accountType,
                'users' => $results,
                'data' => $input,
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
            'selectedCategory' => $category,
            'selectedLocation' => $location,
            'selectedName' => $name,
            'selectedKeyword' => $keyword,
            'selectedPerpage' => $perPage,
            'accountType' => $accountType,
            'users' => $results,
            'data' => $input,
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
        $influencers = Influencers::query()
            ->with(array('user' => function($query) {
              $query->select('id', 'username', 'name');
            }))
            ->get();

        return view('admin.extras', [
            'page' => 6,
            'influencers' => $influencers
        ]);
    }

    public function submitAdminReview(Request $request)
    {
        $input = $request->all();
        $rule = [
            'username' => 'required|string|regex:/(^([a-zA-Z ]+)?$)/',
            'project_title' => 'required|string|regex:/(^([a-zA-Z0-9 ]+)?$)/',
            'review' => 'required|string',
            'brand_name' => 'required|string|regex:/(^([a-z*A-Z ]+)?$)/',
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

        $influencer = User::where('username', '=', $input['username'])->orWhere('name', $input['username'])->get();
        if(count($influencer) > 0)
            $influencer = $influencer[0]->id;
        else
            return redirect()->back()->with('msg', "Influencer not exists.");

        $requests = new Requests;
        $requests->send_id = Auth::user()->id;
        $requests->receive_id = $influencer;
        $requests->created_at = $input['date'];
        $requests->save();

        $request_info = new RequestInfo;
        $request_info->request_id = $requests->id;
        $request_info->title = $input['project_title'];
        $request_info->content = '';
        $request_info->amount = 0;
        $request_info->unit = '';
        $request_info->gift = 0;
        $request_info->status = 0;
        $request_info->accepted = 0;
        $request_info->sr_review = 0;
        $request_info->rs_review = 0;
        $request_info->brand = $input['brand_name'];
        $request_info->save();

        $review = new Review;
        $review->request_id = $requests->id;
        $review->user_id = $influencer;
        $review->review = $input['review'];
        $review->star = $input['totalRating'];
        $review->created_at = $input['date'];
        $review->save();

        $reviews = Review::where('user_id', '=', $influencer)->get();
        $totalRating = 0;
        $reviewCount = 0;
        if(count($reviews) > 0) {
            $reviewCount = count($reviews);
            foreach($reviews as $review)
                $totalRating += $review->star;
        }

        $influencer_id = Influencers::where('user_id', '=', $influencer)->first()->id;
        $influencerInfo = InfluencerInfo::where('influencer_id', '=', $influencer_id)->first();
        $influencerInfo->reviews = $reviewCount;
        $influencerInfo->rating = $totalRating / $reviewCount;

        if (
            $influencerInfo->save()
        ) {
            return redirect()->back()->with('msg', "New review saved successfully!");
        }
        else
            return redirect()->back()->with('msg', "DB error, please try again");
    }

    public function verifyUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

        return redirect()->route('users')->with('msg', 'now in DEV');
    }

    public function featureUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

        $featured = Featured::where('user_id', '=', $user_id)->get();
        if(count($featured) > 0) {
            return redirect()->back()->with('msg', 'Already Featured');
        }

        $featured = new Featured;
        $featured->user_id = $user_id;

        if($featured->save()) {
            return redirect()->back()->with('msg', 'Successful');
        } else {
            return redirect()->back()->with('msg', 'DB error');
        }
    }

    public function unFeatureUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

        $featured = Featured::where('user_id', $user_id)->first();
        if($featured->delete()) {
            return redirect()->back()->with('msg', "Successful");
        } else {
            return redirect()->back()->with('msg', "DB error");
        }
    }

    public function deleteUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

        $user = User::find($user_id);
        if($user->delete()) {
            return redirect()->back()->with('msg', 'Successful');
        } else {
            return redirect()->back()->with('msg', 'DB error');
        }
    }

    public function blockUser(Request $request) {
        $input = $request->all();
        $user_id = $input['userId'];

    }

    public function loginAsUser(Request $request) {
        $input = $request->all();
        $user_id = $input['login_user_id'];
        $user = User::find($user_id);
        Auth::login($user);
        $url = env('APP_URL') . '/home';
        return redirect(url($url));
    }

    public function allUsers($accountType) {
        if($accountType == 'brand')
            $users = Brands::with('user')->paginate(10);
        if($accountType == 'influencer')
            $users = Influencers::with("user")->paginate(10);
        $rank = $users->firstItem();
        return view('admin.users', [
            'rank' => $rank,
            'users' => $users,
            'accountType' => $accountType
        ]);
    }
}
