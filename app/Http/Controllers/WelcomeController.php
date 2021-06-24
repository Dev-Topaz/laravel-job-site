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
}
