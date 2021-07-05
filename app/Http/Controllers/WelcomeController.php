<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Featured;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        if(isset(Auth::user()->id)) {
            return redirect('home');
        } else {
            $influencerInfo = new Featured();
            $influencerInfo = $influencerInfo->getFeaturedInfluencers();

            return view('welcome', [
                'featuredInfluencers' => $influencerInfo,
            ]);
        }
    }

    public function contactUs() {
        return view('contactUs');
    }

    public function submitContactUs(Request $request) {
        $input = $request->all();

        $details = [
            'email' => $input['email'],
            'name' => $input['name'],
            'subject' => $input['subject'],
            'content' => $input['content']
        ];

        \Mail::to('djordjedevelopment@gmail.com')->send(new \App\Mail\ContactUs($details));
    }
}
