@extends('layouts.admin')
@section('content')
    <style>
        input {
            border: 1px solid lightgrey !important;
            padding: 8px 12px !important;
        }
    </style>
    <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
        <p class="italic text-lg text-white font-bold leading-8 pr-2"
           style="font-family: 'Josefin Sans', sans-serif;">{{ __('News Feed') }}</p>
    </div>
    <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
        <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('Referrals') }}</h2>
    </div>
    <div class="w-full px-3 py-3 md:float-left md:w-3/4 lg:w-4/5 xl:w-5/6">
        <div class="w-full">
            <div class="flex flex-col lg:flex-row justify-content-start">
                <div class="w-full lg:w-56 text-center px-3 py-4 mb-3 mx-auto lg:mx-5 rounded-xl bg-white" style="box-shadow: 0 0 3px 5px #eee;">
                    <h1 class="text-xl md:text-5xl" style="color: #0bc2c8">{{ $signUps }}</h1>
                    <p class="text-md md:text-xl">Signups</p>
                </div>
                <div class="w-full lg:w-56 text-center px-3 py-4 mb-3 mx-auto lg:mx-5 rounded-xl bg-white" style="box-shadow: 0 0 3px 5px #eee;">
                    <h1 class="text-xl md:text-5xl" style="color: #0bc2c8">&pound;750</h1>
                    <p class="text-md md:text-xl">Total influencers</p>
                </div>
                <div class="w-full lg:w-56 text-center px-3 py-4 mb-3 mx-auto lg:mx-5 rounded-xl bg-white" style="box-shadow: 0 0 3px 5px #eee;">
                    <h1 class="text-xl md:text-5xl" style="color: #0bc2c8">&pound;250</h1>
                    <p class="text-md md:text-xl">Total brands</p>
                </div>
            </div>
        </div>
        <form action="{{ route('cancelReferral') }}" method="get">
        <div class="w-full pt-3 flex flex-col lg:flex-row justify-content-between">
            <div class="flex justify-content-between align-items-center lg:justify-content-start">
                <input type="checkbox" name="select_all" id="select_all" class="w-6 h-6"/>
                <label for="select_all" class="text-lg mb-0">&nbsp;&nbsp;&nbsp;
                    Select All
                </label>
                <button class="text-white px-3 py-1.5 rounded-md ml-5" style="background: #0bc2c8" type="submit">Cancel Referral</button>
            </div>
            <div class="mt-2 md:mt-0">
                <div class="relative">
                    <label for="username" class="mb-0 w-full">
                        <input type="text" name="username" id="username" placeholder="Search Influencer" class="rounded-lg border-grey w-full">
                    </label>
                    <button class="absolute right-2" style="top: 50%; transform: translateY(-50%);"><li class="fas fa-search" /></button>
                </div>
            </div>
         </div>
        <div class="w-full pt-3">
            <table class="w-full bg-white text-xs md:text-lg">
                <thead>
                <tr class="py-2 px-3" style="border-bottom: 2px solid #999">
                    <th style="width: 5%"></th>
                    <th style="width: 27%">Influencer</th>
                    <th style="width: 27%">Referred by</th>
                    <th style="width: 25%">Location</th>
                    <th style="width: 16%">Social Media</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($referrals) > 0)
                        @foreach($referrals as $referral)
                            <tr class="py-2 py-3">
                                <th><input type="checkbox" name="checked[]" value="{{ $referral->id }}" id="{{ $referral->id }}" class="referral_check"></th>
                                <th>{{ $referral->referralUser->username }}</th>
                                <th>{{ $referral->user->username }}</th>
                                <th>{{ $referral->referralUser->influencersInfo->state . ', ' . $referral->referralUser->influencersInfo->country }}</th>
                                <th>
                                    <div class="w-full grid grid-cols-3 gap-5">
                                        <div>
                                            <a href="{{ 'https://' . $referral->referralUser->profile->instagram }}">
                                                <i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ 'https://' . $referral->referralUser->profile->youtube }}">
                                                <i class="fab fa-youtube text-red-400"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ 'https://' . $referral->referralUser->profile->tiktok }}">
                                                <i class="fab fa-tiktok text-gray-700"></i>
                                            </a>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        </form>
    </div>

    <script>
        $("input#select_all").on('click', function () {
            if($(this).is(':checked')){
                $("input.referral_check").attr('checked', true);
            } else {
                $("input.referral_check").attr('checked', false);
            }
        });
    </script>
@endsection
