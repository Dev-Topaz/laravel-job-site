<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Requests;
use App\Models\Influencers;
use App\Models\Brands;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use App\Models\Countries;
use App\Models\UserTask;
use App\Models\Inboxes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request, $item) {
        $acceptedTasks = [];
        $completedTasks = [];
        $disputedTasks = [];

        $user = new User();
        $requests = new Requests();
        $user_id = Auth::user()->id;
        if($user->checkIfInfluencer($user_id)) {
            $tasks = $requests->getInfluencerTasksByID($user_id);
        } else {
            $tasks = $requests->getBrandTasksByID($user_id);
        }

        foreach ($tasks as $task) {
            if($task->status == 2 || $task->status == 3)
                array_push($acceptedTasks, $task);
            if($task->status == 4) {
                if($user->checkIfInfluencer($user_id)) {
                    if($task->rs_review == 0)
                        array_push($acceptedTasks, $task);
                    else
                        array_push($completedTasks, $task);
                } else {
                    if($task->sr_review == 0)
                        array_push($acceptedTasks, $task);
                    else
                        array_push($completedTasks, $task);
                }
            }
            if($task->status == 5) {
                array_push($disputedTasks, $task);
            }
        }

        $account = new User();
        $accountInfo = $account->getAccountInfoByUserID(Auth::user()->id);

        $unread = $request->get('unread');
        return view('task', [
            'item' => $item,
            'page' => 3,
            'unread' => $unread,
            'acceptedTasks' => $acceptedTasks,
            'completedTasks' => $completedTasks,
            'disputedTasks' => $disputedTasks,
            'accountInfo' => $accountInfo[0],
        ]);
    }

    public function taskDetailShow(Request $request, $request_id) {
        $requests = new Requests();
        $requestsInfo = $requests->getRequestInfoByID($request_id);

        $user = new User();
        $accountInfo = $user->getAccountInfoByUserID($requestsInfo->user_id);

        $userTask = UserTask::where("task_id", '=', $request_id)
                ->where('user_id', '=', Auth::user()->id)
                ->get();
        if(count($userTask) > 0) $userTask[0]->delete();

        $inbox = Inboxes::where('request_Id', '=', $request_id)->first();

        return view('taskDetail', [
            'page' => 3,
            'unread' => $request->get('unread'),
            'requests' => $requestsInfo,
            'accountInfo' => $accountInfo[0],
            'inbox_id' => $inbox->id,
        ]);
    }

    public function search(Request $request) {
        $input = $request->all();
        $rule = [
            'name' => 'nullable|string|max:50|regex:/(^([a-zA-Z ]+)?$)/',
            'keyword' => 'nullable|string|max:30|regex:/(^([a-zA-Z ]+)?$)/',
        ];

        $message = [
            'name.nullable' => '123',
            'name.string' => '123333',
            'name.max' => 'adf',
            'name.regex' => 'Name can contains only letters and space',
            'keyword.regex' => 'Name can contains only letters and space',
        ];

        $validator = Validator::make($input, $rule, $message);

        if($validator->fails()) {
            return redirect()->route('search')
                ->withErrors($validator)
                ->withInput($input);
        }

        $category = (isset($input['category'])) ? $input['category'] : '';
        $location = (isset($input['country'])) ? $input['country'] : '';
        $name = (isset($input['name'])) ? $input['name'] : '';
        $keyword = (isset($input['keyword'])) ? $input['keyword'] : '';
        $perpage = (isset($input['perpage'])) ? $input['perpage'] : 10;

        $account = new User();
        $accountInfo = $account->getAccountInfoByUserID(Auth::user()->id)->first();

        // Get categories
        $allCategories = Category::all();

        // Get countries
        $countries = Countries::all();
        $unread = $request->get('unread');

        if($category == '' && $location == '' && $name =='' && $keyword == '')
        {
            $foundAccounts = [];
            return view('search', [
                'unread' => $unread,
                'selectedCategory' => $category,
                'selectedLocation' => $location,
                'selectedName' => $name,
                'selectedKeyword' => $keyword,
                'selectedPerpage' => 10,
                'data' => $input,
                'page' => 4,
                'accountInfo' => $accountInfo,
                'categories' => $allCategories,
                'countries' => $countries,
                'accounts' => $foundAccounts,
            ]);
        }

        // search influencers
        if($accountInfo->accountType == 'brand') {
            $influencers = new Influencers();
            $foundAccounts = $influencers->getUsers($name, $category, $location, $keyword, $perpage);
        } else {
            $brands = new Brands();
            $foundAccounts = $brands->getUsers($name, $category, $location, $keyword, $perpage);
        }

        return view('search', [
            'unread' => $unread,
            'selectedCategory' => $category,
            'selectedLocation' => $location,
            'selectedName' => $name,
            'selectedKeyword' => $keyword,
            'selectedPerpage' => $perpage,
            'data' => $input,
            'page' => 4,
            'accountInfo' => $accountInfo,
            'categories' => $allCategories,
            'countries' => $countries,
            'accounts' => $foundAccounts,
        ]);
    }
}
