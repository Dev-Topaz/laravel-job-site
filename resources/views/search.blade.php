@extends('layouts.app')

@section('content')
<style type="text/css">
  .page-item.active .page-link {
    background-color: #4ad7c4;
    border-color: #4ad7c4;
  }
  .pagination {
    justify-content: flex-end;
  }
  li.page-item {

        display: none;
    }

    .page-item:first-child,
    .page-item:nth-child( 2 ),
    .page-item:nth-last-child( 2 ),
    .page-item:last-child,
    .page-item.active,
    .page-item.disabled {

        display: block;
    }
</style>
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">
        @if ($accountInfo->accountType == 'brand')
            {{ __('SEARCH FOR INFLUENCERS') }}
        @else
            {{ __('SEARCH FOR BRANDS') }}
        @endif
    </p>
  </div>
</header>
  <main class="md:max-w-7xl mx-auto">
    <div class="w-full md:max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3 mb-20">
      <!-- Replace with your content -->
        <div class="bg-white">
          <div id="name" class="tabcontent w-11/12 mx-auto">
            <form action={{ route('search') }} method="get" id="nameForm">
              @csrf
              <select name="category" id="category" class="w-full border-none rounded-md my-3" style="box-shadow: 0 0 3px 0 #999999">
                <option value=""><label class="text-xs md:text-sm"  for="category">Categories</label></option>
                @foreach ($categories as $category)
                  @if ($category->id == $selectedCategory)
                    <option value={{ $category->id }} selected> <label class="text-xs md:text-sm" for='category'>{{ $category->category_name }}</label> </option>
                  @else
                    <option value={{ $category->id }}> <label class="text-xs md:text-sm" for='category'>{{ $category->category_name }}</label> </option>
                  @endif
                @endforeach
              </select>

              <select name="country" id="country" class="w-full border-none rounded-md my-2 text-black" style="box-shadow: 0 0 3px 0 #999999">
                <option value=""><label class="text-xs md:text-sm" for="location">Location</label></option>
                @foreach ($countries as $country)
                  @if ($country->name == $selectedLocation)
                    <option value="{{ $country->name }}" selected> <label class="text-xs md:text-sm" for='location'>{{ $country->name }}</label> </option>
                  @else
                    <option value="{{ $country->name }}"> <label class="text-xs md:text-sm" for='location'>{{ $country->name }}</label> </option>
                  @endif
                @endforeach
              </select>

                <input type="text" name="name" id="name" style="border: 1px solid lightgray" class="block w-full mx-auto rounded text-gray-700 font-semibold my-2 h-10 shadow-inner @error('name') is-invalid @enderror" placeholder="Name" value={{$selectedName}} >
                @error('name')
                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                @enderror

                <input type="text" name="keyword" id="keyword" style="border: 1px solid lightgray" class="block w-full mx-auto rounded text-gray-700 font-semibold my-2 h-10 shadow-inner" placeholder="keyword"  value = {{$selectedKeyword}}>
                @error('keyword')
                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                @enderror

                <button type="submit" class="font-semibold block w-1/3 mx-auto rounded-lg py-2 text-white mt-2" style="background: linear-gradient(to right, #47afbe, #4addc4)"  id="category_search_btn">Search</button>
            </form>
          </div>
          <div class="w-full">
            <div class="my-3" id="searchTab" style="border-top: solid 1px lightgray; border-bottom: solid 1px lightgray">
              <div class="w-11/12 mx-auto grid grid-cols-12 h-10">
                <a class="block col-span-3 w-full h-full text-gray-500" id="full-view">
                  <button class="block mx-auto w-12 h-full">
                    <i class="fas fa-bars leading-10"></i>
                  </button>
                </a>
                <a class="block col-span-3 w-full h-full text-gray-500 active" id="grid-view">
                  <button class="block mx-auto w-12 h-full">
                    <i class="fas fa-border-all leading-10"></i>
                  </button>
                </a>
                <div class="col-span-6 w-full h-10">
                  <select name="perpage" id="perPage" form="nameForm" class="w-10/12 float-right rounded-md text-xs md:text-sm h-8 my-1 py-1" style="border: solid 1px lightgray">
                    <option value="10" @if($selectedPerpage == 10) selected @endif>10 per page</option>
                    <option value="20" @if($selectedPerpage == 20) selected @endif>20 per page</option>
                    <option value="50" @if($selectedPerpage == 50) selected @endif>50 per page</option>
                    <option value="100" @if($selectedPerpage == 100) selected @endif>100 per page</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='grid-view'>
          <div class="w-11/12 mx-auto grid grid-cols-2 gap-x-3 gap-y-4">
          @if (count($accounts) == 0)
              <p class="text-center text-sm md:text-md text-gray-500">No matching accounts.</p>
          @else
          @foreach ($accounts as $account)
          <div>
              <a href="{{ route('profile', ['username' => $account->user->username]) }}">
                <div class="w-full float-left rounded-lg py-2" style="box-shadow: 0 0 3px 3px #eee">
                  <div class="w-11/12 mx-auto relative">
                    <div class="w-8/12 mx-auto rounded-full px-1 py-1 mt-3" style="background: linear-gradient(to right, #06ebbe, #1277d3)" >
                      <img class="rounded-full w-full" src="{{ url('/storage/profile-image/').'/'.$account->accountInfo->avatar.'.jpg' }}" alt="$account->avatar" style="border:solid 2px white">
                    </div>
                  </div>
                  <div class="mt-2">
                      <h3 class="text-center text-sm md:text-md font-bold text-gray-700">{{ $account->user->name }}</h3>
                      <p class="text-center text-xs md:text-sm text-gray-500">{{ '@'.$account->user->username }}</p>
                      <div style="height: 30px; display: flex; align-items: center; justify-content: center;">
                        <p class="text-center text-xs md:text-sm text-gray-700"><i class="fas fa-map-marker-alt" style="color: #119dab"></i> {{ ucwords($account->accountInfo->state).', '.ucwords($account->accountInfo->country) }}</p>                      
                      </div>
                  </div>
                  <div class="mt-1 w-full">
                    <div class="text-xs md:text-sm flex justify-center">
                      <span class="px-2 bg-yellow-400 rounded text-white mr-1" style="line-height:20px;">{{ number_format($account->accountInfo->rating, 1) }}</span>
                      <span style="line-height:20px;">
                        @for ($i = 0; $i < 5; $i++)
                          @if ($account->accountInfo->rating > $i)
                            <i class="fas fa-star text-yellow-400"></i>
                          @else
                            <i class="fas fa-star text-gray-400"></i>
                          @endif
                        @endfor
                      </span>
                      <span class="ml-1 text-gray-700 font-bold" style="line-height: 20px;">({{ $account->accountInfo->reviews }})</span>
                    </div>
                  </div>
                  <div class="mt-2 w-full">
                    <div class="text-xs md:text-sm flex justify-center">
                      @if (count($account->category) > 0)
                          @foreach($account->category as $category)
                              <div class="px-1 text-center py-1 rounded mx-1" style="background:{{ '#' . $category->back_color }}; color:{{ '#' . $category->text_color}};">
                                <p>{{ $category->category_name }}</p>
                              </div>
                            @endforeach
                      @else
                      <div style="height: 24px;"></div>
                      @endif
                    </div>
                  </div>
                  <div class="mt-3 w-10/12 mx-auto" style="border-top: 1px solid lightgray">
                    <div class="text-lg md:text-xl text-center flex justify-between pt-1">
                      <div class="w-1/3 text-center">
                        <p><i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i></p>
                        <p class="mt-1 text-gray-700 tracking-tighter" style="font-size: 10px; line-height:10px;">
                          @switch($account->profile->instagram_follows)
                              @case(11)
                                  1k-10k
                                  @break
                              @case(60)
                                  10k-50k
                                  @break
                              @case(150)
                                  50k-100k
                                  @break
                              @case(600)
                                  100k-500k
                                  @break
                              @case(501)
                                  500k-1m
                                  @break
                              @case(6)
                                  1m-5m
                                  @break
                              @case(15)
                                  5m-10m
                                  @break
                              @case(10)
                                  10m+
                                  @break
                              @default
                                  unknown
                                  @break
                          @endswitch
                        </p>
                      </div>
                      <div class="w-1/3 text-center" style="border-right: 1px solid lightgray; border-left:1px solid lightgray">
                        <p><i class="fab fa-youtube text-red-400"></i></p>
                        <p class="mt-1 text-gray-700 tracking-tighter" style="font-size: 10px; line-height:10px;">
                          @switch($account->profile->youtube_follows)
                              @case(11)
                                  1k-10k
                                  @break
                              @case(60)
                                  10k-50k
                                  @break
                              @case(150)
                                  50k-100k
                                  @break
                              @case(600)
                                  100k-500k
                                  @break
                              @case(501)
                                  500k-1m
                                  @break
                              @case(6)
                                  1m-5m
                                  @break
                              @case(15)
                                  5m-10m
                                  @break
                              @case(10)
                                  10m+
                                  @break
                              @default
                                  unknown
                                  @break
                          @endswitch
                        </p>
                      </div>
                      <div class="w-1/3 text-center">
                        <p><i class="fab fa-tiktok text-gray-700"></i></p>
                        <p class="mt-1 text-gray-700 tracking-tighter" style="font-size: 10px; line-height:10px;">
                          @switch($account->profile->tiktok_follows)
                              @case(11)
                                  1k-10k
                                  @break
                              @case(60)
                                  10k-50k
                                  @break
                              @case(150)
                                  50k-100k
                                  @break
                              @case(600)
                                  100k-500k
                                  @break
                              @case(501)
                                  500k-1m
                                  @break
                              @case(6)
                                  1m-5m
                                  @break
                              @case(15)
                                  5m-10m
                                  @break
                              @case(10)
                                  10m+
                                  @break
                              @default
                                  unknown
                                  @break
                          @endswitch
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
          </div>
            @endforeach
            <div class="clearfix"></div>
          </div>
          <div class="w-11/12 my-2 mx-auto">
            {{ $accounts->appends($data)->links('pagination::bootstrap-4') }}            
          </div>
          @endif
        </div>
        <div class="full-view">
          <div class="w-11/12 mx-auto">
            @if (count($accounts) == 0)
                <p class="text-center text-sm md:text-md text-gray-500">No matching accounts.</p>
            @else
            @foreach ($accounts as $account)
            <a href={{ route('profile', ['username' => $account->user->username]) }}>
              <div class="w-10/12 md:max-w-7xl mx-auto rounded-lg py-6 mb-5" style="box-shadow: 0 0 3px 3px #eee">
                <div class="w-11/12 mx-auto relative">
                  <div class="w-8/12 mx-auto rounded-full px-1 py-1 mt-3" style="background: linear-gradient(to right, #06ebbe, #1277d3)" >
                    <img class="rounded-full w-full" src="{{ url('/storage/profile-image/').'/'.$account->accountInfo->avatar.'.jpg' }}" alt="$account->avatar" style="border:solid 2px white">
                  </div>
                </div>
                <div class="mt-2">
                    <h3 class="text-center text-md md:text-lg font-bold text-gray-700">{{ $account->user->name }}</h3>
                    <p class="text-center text-sm md:text-sm text-gray-500">{{ '@'.$account->user->username }}</p>
                    <div style="height: 30px; display: flex; align-items: center; justify-content: center;">
                      <p class="text-center text-sm md:text-sm text-gray-700"><i class="fas fa-map-marker-alt" style="color: #119dab"></i> {{ ucwords($account->accountInfo->state).', '.ucwords($account->accountInfo->country) }}</p>
                    </div>
                </div>
                <div class="mt-1 w-full">
                  <div class="text-xs md:text-sm flex justify-center">
                    <span class="px-2 bg-yellow-400 rounded text-white mr-1" style="line-height:20px;">{{ number_format($account->rating, 1) }}</span>
                    <span style="line-height:20px;">
                      @for ($i = 0; $i < 5; $i++)
                        @if ($account->accountInfo->rating > $i)
                          <i class="fas fa-star text-yellow-400"></i>
                        @else
                          <i class="fas fa-star text-gray-400"></i>
                        @endif
                      @endfor
                    </span>
                    <span class="ml-1 text-gray-700" style="line-height: 20px;">({{ $account->accountInfo->reviews }})</span>
                  </div>
                </div>
                <div class="mt-2 w-full">
                  <div class="text-xs md:text-sm flex justify-center">
                    @if (count($account->category) > 0)
                        @foreach($account->category as $category)
                            <div class="px-1 text-center py-1 rounded mx-1" style="background: {{ '#' . $category->back_color }};color:{{ '#' . $category->text_color}};">
                              <p>{{ $category->category_name }}</p>
                            </div>
                          @endforeach
                    @else
                    <div style="height: 24px;"></div>
                    @endif
                  </div>
                </div>
                <div class="mt-2 w-10/12 mx-auto" style="border-top: 1px solid lightgray">
                  <div class="text-lg md:text-xl text-center flex justify-between pt-1">
                    <div class="w-1/3 text-center">
                      <p><i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i></p>
                      <p class="text-xs md:text-sm mt-1 text-gray-700 tracking-tighter">
                          @switch($account->profile->instagram_follows)
                              @case(11)
                                  1k-10k
                                  @break
                              @case(60)
                                  10k-50k
                                  @break
                              @case(150)
                                  50k-100k
                                  @break
                              @case(600)
                                  100k-500k
                                  @break
                              @case(501)
                                  500k-1m
                                  @break
                              @case(6)
                                  1m-5m
                                  @break
                              @case(15)
                                  5m-10m
                                  @break
                              @case(10)
                                  10m+
                                  @break
                              @default
                                  unknown
                                  @break
                          @endswitch
                      </p>
                    </div>
                    <div class="w-1/3 text-center" style="border-right: 1px solid lightgray; border-left:1px solid lightgray">
                      <p><i class="fab fa-youtube text-red-400"></i></p>
                      <p class="text-xs md:text-sm mt-1 text-gray-700 tracking-tighter">
                          @switch($account->profile->youtube_follows)
                              @case(11)
                                  1k-10k
                                  @break
                              @case(60)
                                  10k-50k
                                  @break
                              @case(150)
                                  50k-100k
                                  @break
                              @case(600)
                                  100k-500k
                                  @break
                              @case(501)
                                  500k-1m
                                  @break
                              @case(6)
                                  1m-5m
                                  @break
                              @case(15)
                                  5m-10m
                                  @break
                              @case(10)
                                  10m+
                                  @break
                              @default
                                  unknown
                                  @break
                          @endswitch
                      </p>
                    </div>
                    <div class="w-1/3 text-center">
                      <p><i class="fab fa-tiktok text-gray-700"></i></p>
                      <p class="text-xs md:text-sm mt-1 text-gray-700 tracking-tighter">
                          @switch($account->profile->tiktok_follows)
                              @case(11)
                                  1k-10k
                                  @break
                              @case(60)
                                  10k-50k
                                  @break
                              @case(150)
                                  50k-100k
                                  @break
                              @case(600)
                                  100k-500k
                                  @break
                              @case(501)
                                  500k-1m
                                  @break
                              @case(6)
                                  1m-5m
                                  @break
                              @case(15)
                                  5m-10m
                                  @break
                              @case(10)
                                  10m+
                                  @break
                              @default
                                  unknown
                                  @break
                          @endswitch
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </a>
              @endforeach
              <div class="clearfix"></div>
            </div>
            <div class="w-11/12 mx-auto">
            {{ $accounts->appends($data)->links('pagination::bootstrap-4') }}            
            </div>
            @endif
        </div>
      </div>
    </div>
  </main>
  <script>
    $("div.full-view").hide();
  </script>
  @endsection
