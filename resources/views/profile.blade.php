@extends('layouts.app')
@section('content')
<style type="text/css">
  a.inactive {
    pointer-events: none;
    background: gray !important;
  }
  input, select {
    border: 1px solid lightgray;
  }
  @keyframes loading {
      from {width: 80%}
      to {width: 70%}
  }
  #loading-fav {
    animation-name: loading;
    animation-duration: 2s;
    animation-iteration-count: infinite;
    animation-direction: alternate-reverse;
    animation-timing-function: ease-in-out;
  }
</style>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<div id="loading" class="h-screen w-screen bg-white fixed top-0 left-0" style="z-index: 1000;">
  <div class="w-full h-full flex align-items-center justify-content-center">
    <img src="{{ asset('img/loading.jpg') }}" id="loading-fav">
  </div>
</div>
<main>
  <div id="modal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
      <div class="w-8/12 mx-auto h-26 mt-4">
        <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Would you like to request a collaboration with <span class="text-lg font-bold">{{ $accountInfo->name }}</span>?</p>
      </div>
      <div class="w-full h-16" id="confirmBtn">
        <div class="w-full grid grid-cols-2 h-full">
          <div class="col-span-1 h-full">
            <button class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white" onclick="$('div#modal').hide()">Cancel</button>
          </div>
          <div class="col-span-1">
            <a class="w-full h-full block mx-auto px-4 py-1 text-center rounded-br-lg text-white font-bold text-md md:text-lg" style="background:rgb(88,183,189); line-height:64px;" onclick="sendRequest()">Yes</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="successAlert" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
      <div class="w-8/12 mx-auto mt-4">
        <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5 py-3">Request Sent</p>
      </div>
    </div>
  </div>

  <div class="w-full md:max-w-7xl mx-auto mb-12">
    <!-- Replace with your content -->
      <div class="bg-white">
        <div class="w-full relative">
          <div class="relative">
            <a href={{ route('home') }}>
              <div class="absolute top-4 left-2 rounded-full h-8 w-8 bg-white text-center" style="box-shadow: 0 0 15px #999">
                <p class="leading-8 text-gray-400 text-lg">
                  <i class="fas fa-arrow-left"></i>
                </p>
              </div>
            </a>
            <a onclick="toggleSaved()">
              <div class="absolute top-4 right-2 rounded-full h-8 w-8 bg-white text-center" style="box-shadow: 0 0 15px #999">
                @if ($saved)
                  <p class="leading-8 text-gray-400" style="color: #0f97cd" id="saved">
                    <i class="fas fa-heart"></i>
                  </p>
                @else
                  <p class="leading-8 text-gray-400 text-lg" id="saved">
                    <i class="fas fa-heart"></i>
                  </p>
                @endif
              </div>
            </a>
            <img src="{{ url('/storage/profile-image/'.$profile->top_img.'.jpg') }}" alt="{{ $profile->top_img }}" onload="$('#loading').css('display', 'none');">
            <div class="w-10/12 absolute px-2 pb-2 bottom-5 bg-white h-36 md:h-40" style="left: 50%; margin-left: -41%; bottom:60px">
              <div class="relative ml-2 h-8">
                <div class="absolute" style="width: 33%;bottom:0;">
                  <img src={{ url('/storage/profile-image/'.$profile->round_img.'.jpg') }} alt={{ $profile->round_img }} class="rounded-full" style="border:3px solid white">
                </div>
                @if($accountInfo->loggedIn)
                <div style="margin-left: 30%; display: flex; align-content: center;" class="h-full text-green-500">
                  <span><i class="fas fa-circle" style="font-size: 5px; line-height:2rem;"></i></span>
                  <span class="leading-8 text-xs md:text-sm text-gray-500" style="line-height: 2rem;font-family: 'Poppins', sans-serif; font-weight: 500;">&nbsp;&nbsp;
                    Active now
                  </span>
                </div>
                @else
                <div style="margin-left: 30%;display: flex; align-content: center;" class="h-full text-gray-500">
                  <span><i class="fas fa-circle" style="font-size: 5px; line-height:2rem;"></i></span>
                  <span class="leading-8 text-xs md:text-sm" style="line-height: 2rem;" style="font-family: 'Poppins', sans-serif; font-weight: 500;">&nbsp;&nbsp;
                    last seen {{ $accountInfo->interval }} ago
                  </span>
                </div>
                @endif
              </div>
              <div class="relative ml-2">
                <div class="float-left w-8/12" style="font-family: 'Poppins', sans-serif;">
                  <p class="text-md md:text-lg font-bold" style="font-weight:600">{{ $accountInfo->name }}</p>
                  <p class="text-xs md:text-sm text-gray-700" style="font-weight: 400;">{{ '@'.$accountInfo->username }}</p>
                  <div class="text-sm md:text-md">
                    <span class="px-1 rounded text-white font-bold rounded-lg mr-1 text-xs md:text-sm" style="padding: 1px 3px; line-height:20px; background:#f5a321;">{{ number_format($accountInfo->rating, 1) }}</span>
                    <span style="line-height:26px;">
                      @for ($i = 0; $i < 5 ; $i++)
                        @if ($accountInfo->rating > $i)
                          <i class="fas fa-star" style="color: #f5a321"></i>
                        @else
                          <i class="fas fa-star text-gray-400"></i>
                        @endif
                      @endfor
                    </span>
                  @if ($accountInfo->reviews != 0)
                    <span class="text-sm ml-1 text-gray-700 font-bold" style="line-height: 20px;"><span>(</span>{{ $accountInfo->reviews }}<span>)</span></span>
                  @endif
                  </div>
                  <p class="text-xs md:text-md text-gray-700 mt-1" style="font-weight: bold;width: 150%;"><i style="color: #119dab" class="fas fa-map-marker-alt"></i> {{ ucwords($accountInfo->state).', '.ucwords($accountInfo->country) }}</p>
                </div>
                <div class="relative float-right w-4/12 pr-2 pt-3" style="font-family: 'Poppins', sans-serif;">
                  @if(count($categories) > 0)
                  <div class="mb-2 px-1 py-1 rounded-lg w-full" style="background:#{{ $categories[0]->back_color }}">
                    <p class="text-sm text-center" style="color: {{ __('#') . $categories[0]->text_color }}; font:11px monospace;">{{ $categories[0]->category_name }}</p>
                  </div>
                @endif
                    @if(count($categories) > 1)
                  <div class="mb-2 px-1 py-1 rounded-lg w-full" style="background: {{__('#') . $categories[1]->back_color }}">
                    <p class="text-sm text-center" style="color: {{__('#') . $categories[1]->text_color }}; font:11px monospace;">{{ $categories[1]->category_name }}</p>
                  </div>
                  @endif
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            <div id="social_links" class="flex justify-content-between align-items-center" style="position: absolute; bottom: 40px;right: 10%; width:150px;">
              @if($profile->tiktok_check == 1)
              <div class="w-10 h-10 rounded-full mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                <a href="@if(substr($profile->tiktok, 0, 4) == 'http'){{ $profile->tiktok }}@else//{{ $profile->tiktok }}@endif" class="text-center leading-10"><i class="fab fa-tiktok" style="color: #333;"></i></a>
              </div>
              @endif
              @if($profile->youtube_check == 1)
              <div class="w-10 h-10 rounded-full mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                <a href="@if(substr($profile->youtube, 0, 4) == 'http'){{ $profile->youtube }}@else//{{ $profile->youtube }}@endif" class="text-center leading-10 text-red-700"><i class="fab fa-youtube" style="color: #333;"></i></a>
              </div>
              @endif
              @if($profile->instagram_check == 1)
              <div class="w-10 h-10 rounded-full mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                <a href="@if(substr($profile->instagram, 0, 4) == 'http'){{ $profile->instagram }}@else//{{ $profile->instagram }}@endif" class="text-center leading-10"><i class="fab fa-instagram" style="color: #333;"></i></a>
              </div>
              @endif
              @if($profile->website_check == 1)
              <div class="w-10 h-10 rounded-full mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                <a href="@if(substr($profile->website, 0, 4) == 'http'){{ $profile->website }}@else//{{ $profile->website }}@endif" class="text-center leading-10"><i class="fas fa-globe" style="color: #333;"></i></a>
              </div>
              @endif
            </div>
          </div>
          <div class="h-8 rounded-t-2xl bg-white w-full absolute -bottom-1"></div>
        </div>
        <div class="w-full pt-2 pb-8">
          <div class="w-11/12 mx-auto rounded-lg bg-gray-200" style="font-family: 'Poppins', sans-serif; font-weight: 600; ">
            <div class="w-full grid grid-cols-2">
              <div class="col-span-1 px-1 py-1">
                <button class="tablink py-1 rounded-lg w-full text-gray-500 font-bold" onclick="openTab('profile', this)" id="defaultOpen">Profile</button>
              </div>
              <div class="col-span-1 px-1 py-1">
                <button class="tablink py-1 rounded-lg w-full text-gray-500 font-bold" onclick="openTab('reviews', this)">Reviews</button>
              </div>
            </div>
          </div>
          <div id="profile" class="tabcontent w-full mx-auto">
            <div id="introduction" class="w-11/12 mx-auto my-2 py-3">
              <p class="text-md md:text-lg">
                {{ $profile->introduction }}
              </p>
            </div>
            <div id="portfolio" class="py-8 w-full mx-auto bg-gray-100" style="border-top: 1px solid lightgray; border-bottom: 1px solid lightgray">
              @if (count($portfolios) > 0)
              <div id="portfolio-slide" class="w-full overflow-hidden relative">
                <div style="width: 150%;">
                  <div class="swiper-container w-full h-full">
                    <div class="swiper-wrapper" style="padding-left: 30px;">
                      @foreach ($portfolios as $item)
                          <div class="swiper-slide overflow-hidden rounded-xl" onload="resize()">
                            <img src="{{ url('/storage/profile-image/' . $item->slide_img . '.jpg') }}" alt="{{ $item->slide_img }}" style="width: 100%;" class="relative">
                          </div>
                      @endforeach
                      <div class="swiper-slide"></div>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="w-full my-2 text-center">
              </div>
              @endif
            </div>

          @if ($accountInfo->accountType == 'influencer')
            <div id="partnership" class="w-11/12 mx-auto" style=" padding-bottom: 50px !important;">
              <p class="text-center text-gray-400 py-2 mt-3 text-md md:text-lg tracking-wide" style="font-family: 'Poppins', sans-serif; font-weight:500;">
                INFLUENCER PARTNERSHIPS
              </p>
              <div id="partnership_slide">
                <div class="w-full mx-auto">
                  <div id="partnerships" class="carousel slide rounded-xl relative z-10" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                      <li data-target="#partnerships" data-slide-to="0" class="active"></li>
                      @for ($i = 1; $i < count($partnerships); $i++)
                        <li data-target="#partnerships" data-slide-to={{ $i + 1 }}></li>
                      @endfor
                    </ul>
                    <!-- The slideshow -->
                    <div class="carousel-inner">
                      @if(count($partnerships) > 0)
                      <div class="carousel-item active">
                        <img class="w-9/12 mx-auto rounded-xl" src={{ url('/storage/partnership-image/'.$partnerships[0]->partnership_img).'.jpg' }} alt={{ $partnerships[0]->partnership_img }} >
                      </div>
                      @for ($i = 1; $i < count($partnerships); $i++)
                      <div class="carousel-item">
                        <img class="w-9/12 mx-auto rounded-xl" src={{ url('/storage/partnership-image/'.$partnerships[$i]->partnership_img).'.jpg' }} alt={{ $partnerships[$i]->partnership_img }}>
                      </div>
                      @endfor
                      @else
                      <div class="text-center w-full">
                        <p class="text-sm md:text-md"></p>
                      </div>
                      @endif

                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif

        </div>
          <div id="reviews" class="tabcontent w-11/12 mx-auto pb-10">
            <div id="reviews" class="w-11/12 mx-auto my-8">
              @if (count($reviews) == 0)
                <p class="text-center text-md md:text-lg">
                  No reviews yet.
                </p>
              @else
                @foreach ($reviews as $review)
                  <div class="title my-2">
                    <p class="text-lg md:text-xl font-semibold">
                      {{ $review->title }}
                    </p>
                  </div>
                  <div class="rating my-2">
                    <span class="px-2 py-1 bg-yellow-400 rounded-md text-white text-xs md:text-sm font-bold">{{ number_format($review->star, 1) }}</span>
                    @for ($i = 0; $i < 5; $i++)
                      @if ($review->star > $i)
                        <i class="fas fa-star text-yellow-400"></i>
                      @else
                        <i class="fas fa-star text-gray-400"></i>
                      @endif
                    @endfor
                  </div>
                  <div class="review my-2">
                    <p class="text-sm md:text-md">{{ $review->review }}</p>
                  </div>
                  <div class="com my-2">
                    @if (count(explode('-', $review->interval)) > 0)
                    <p class="text-xs md:text-sm text-gray-500">by {{ ($review->status == 0) ? $review->brand : $review->name }} - {{ $review->interval }}</p>
                    @else
                    <p class="text-xs md:text-sm text-gray-500">by {{ ($review->status == 0) ? $review->brand : $review->name }} - {{ $review->interval }} ago</p>
                    @endif
                  </div>
                  <hr class="mt-3">
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full fixed bottom-0 z-50 bg-white">
      <div class="w-full md:max-w-7xl mx-auto py-3" style="border-top: 1px solid lightgray">
        <div class="w-8/12 mx-auto">
            @auth
              @if ($accountInfo->id == Auth::user()->id)
                  <a href="{{ route('editProfile', ['username' => Auth::user()->username]) }}" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Edit</a>
              @else
                  @if ($accountInfo->accountType == 'influencer')
                  <a href="{{ route('collaborate', ['user_id' => $accountInfo->id]) }}" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Collaborate</a>
                  @else
                  <a onclick="$('div#modal').show();" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" id="sendRequest" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Request</a>
                  @endif
              @endif
            @else
              @if ($accountInfo->accountType == 'influencer')
              <a href="{{ route('collaborate', ['user_id' => $accountInfo->id]) }}" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Collaborate</a>
              @else
              <a onclick="$('div#modal').show();" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" id="sendRequest" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Request</a>
              @endif
            @endAuth

        </div>
      </div>
    </div>
</main>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
  var swiper=new Swiper(".swiper-container",{slidesPerView:2,spaceBetween:35,freeMode:!0});function openTab(e,t){var n,o,s,a=$("div.swiper-slide").css("width");for(null!=a&&(a=a.slice(0,-2),height=1.1*parseInt(a),$("div.swiper-slide").css("height",height+"px")),o=document.getElementsByClassName("tabcontent"),n=0;n<o.length;n++)o[n].style.display="none";for(s=document.getElementsByClassName("tablink"),n=0;n<s.length;n++)s[n].style.backgroundColor="";document.getElementById(e).style.display="block",t.style.backgroundColor="white"}function toggleSaved(){var e="{{ url('/') }}/api/savedToggle/{{$accountInfo->id}}?api_token=";e+=$("meta[name=api-token]").attr("content"),$.ajax({url:e,type:"GET",headers:{Accept:"application/json"},success:function(e){1==e.data?$("p#saved").css("color","#0f97cd"):$("p#saved").css("color","rgb(156, 163, 175)")},error:function(e,t,n){}})}function sendRequest(){const e='{{ url("/") }}/api/influencerRequest/{{ $accountInfo->id }}?api_token='+$("meta[name=api-token]").attr("content");$.ajax({url:e,type:"get",success:function(e){$("div#modal").hide(),$("div#successAlert").fadeIn(200).delay(2e3).fadeOut(200),$("a#sendRequest").addClass("inactive"),$("a#sendRequest").text("Requested")},error:function(e,t,n){}})}document.getElementById("defaultOpen").click();

</script>
@endsection
