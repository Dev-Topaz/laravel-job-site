@extends('layouts.admin')
@section('content')
    <style>
        #searchContent label {
            display: none;
        }

        #searchContent * {
            color: grey;
        }

        input, select {
            padding: 8px !important;
            border: 1px solid lightgrey;
        }

        a.active {
            border-bottom: 3px solid #0bc2c8 !important;
        }
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
    <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
        <p class="italic text-lg text-white font-bold leading-8 pr-2"
           style="font-family: 'Josefin Sans', sans-serif;">{{ __('Users') }}</p>
    </div>
    <div class="md:h-screen md:overflow-auto">
        <div>
            <div class="hidden md:block float-left pl-5 pt-4">
                <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('Users') }}</h2>
            </div>
            <div class="w-full px-3 py-3 md:float-left" id="searchContent">
                <form action="{{ route('users') }}" method="get">
                    <div class="hidden md:block w-full gap-y-2 md:grid md:grid-cols-4 xl:grid-cols-8 md:gap-x-2">
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <a class="searchInfluencer active block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-sm"
                                   style="border-bottom-color: #07c2c8">
                                    {{__('Influencers')}}
                                </a>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <a class="searchBrand block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-sm"
                                   style="border-bottom-color: #07c2c8">
                                    {{__('Brands')}}
                                </a>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <label for="categories"></label>
                                <select name="categories" id="categories"
                                        class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
                                    <option value="">Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <label for="location"></label>
                                <select name="location" id="location"
                                        class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
                                    <option value="">Location</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <label for="name"></label>
                                <input type="text" name="name" id="name" placeholder="Name"
                                       class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <label for="keyword"></label>
                                <input type="text" name="keyword" id="keyword" placeholder="Keyword"
                                       class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <button
                                    class="block w-4/5 py-2 text-white rounded-sm border-none focus:outline-none text-sm"
                                    style="background: linear-gradient(to right, #47afbe, #5fe4ce)">Search
                                </button>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="w-full px-2">
                                <label for="perpage"></label>
                                <select name="perpage" id="perpage"
                                        class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
                                    <option value="8">8 per page</option>
                                    <option value="20">20 per page</option>
                                    <option value="40">40 per page</option>
                                    <option value="100">100 per page</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="accountType" class="accountType">
                </form>

                {{--Mobile view--}}
                <form action="{{ route('users') }}" method="get">
                    <div class="md:hidden w-full">
                        <div class="w-full px-2 pb-2">
                            <label for="categories"></label>
                            <select name="categories" id="categories"
                                    class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
                                <option value="">Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full px-2 pb-2">
                            <label for="location"></label>
                            <select name="location" id="location"
                                    class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
                                <option value="">Location</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full px-2 pb-2">
                            <label for="name"></label>
                            <input type="text" name="name" id="name" placeholder="Name"
                                   class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
                        </div>
                        <div class="w-full px-2 pb-2">
                            <label for="keyword"></label>
                            <input type="text" name="keyword" id="keyword" placeholder="Keyword"
                                   class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
                        </div>
                        <div class="w-full px-2 pb-2">
                            <button
                                class="block w-2/5 mx-auto py-2 text-white rounded-sm border-none focus:outline-none text-xs"
                                style="background: linear-gradient(to right, #47afbe, #5fe4ce)" type="submit">Search
                            </button>
                        </div>
                        <div class="w-full border-top border-bottom border-gray-400">
                            <div class="w-full grid grid-cols-3 gap-x-2">
                                <div class="col-span-1 text-center flex flex-wrap items-center justify-content-center">
                                    <i class="fas fa-bars" style="color: #07c2c8;"></i>
                                </div>
                                <div class="col-span-1 text-center flex flex-wrap items-center justify-content-center">
                                    <i class="fas fa-border-all" style="color: #07c2c8;"></i>
                                </div>
                                <div class="col-span-1 w-full flex flex-wrap items-center justify-content-center">
                                    <label for="perpage"></label>
                                    <select name="perpage" id="perpage"
                                            class="w-full rounded-sm border-gray-300 bg-transparent my-1.5 py-0.5 px-1 text-xs">
                                        <option value="8">8 per page</option>
                                        <option value="20">20 per page</option>
                                        <option value="40">40 per page</option>
                                        <option value="100">100 per page</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-full grid grid-cols-3">
                            <div class="col-span-1">
                                <div class="w-full px-2 pb-2">
                                    <a class="searchInfluencer active block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-xs"
                                       style="border-bottom-color: #07c2c8">
                                        {{__('Influencers')}}
                                    </a>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div class="w-full px-2 pb-2">
                                    <a class="searchBrand block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-xs"
                                       style="border-bottom-color: #07c2c8">
                                        {{__('Brands')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="accountType" class="accountType">
                </form>
            </div>
            <div id="users">
                @if(count($users) > 0)
                    <div class="w-full grid grid-cols-2 lg:grid-cols-4 gap-3 px-3">
                        @foreach($users as $user)
                            <div class="col-span-1">
                                <div class="relative w-full rounded-lg shadow-md px-2 py-3 bg-white">
                                    <div id="user-edit" class="absolute top-3 right-3">
                                        <a onclick="$(this).parent().siblings('div#edit-modal').toggle();">
                                            <li class="fas fa-pencil-alt text-sm"></li>                                            
                                        </a>
                                    </div>
                                    <div id="edit-modal" class="absolute top-10 right-5 hidden bg-white rounded-md px-2 py-2 text-xs">
                                        <ul>
                                            <li><a onclick="verifyUser({{ $user->user->id }})" class="block py-1 border-bottom text-decoration-none pr-7">Verify</a></li>
                                            @if($user->user->featured == null)
                                            <li><a onclick="featureUser({{ $user->user->id }})" class="block py-1 border-bottom text-decoration-none pr-7">Feature</a></li>
                                            @else
                                            <li><a onclick="unFeatureUser({{ $user->user->id }})" class="block py-1 border-bottom text-decoration-none pr-7">Unfeature</a></li>
                                            @endif
                                            <li><a onclick="blockUser({{ $user->user->id }})" class="block py-1 border-bottom text-decoration-none pr-7">Block</a></li>
                                            <li><a onclick="deleteUser({{ $user->user->id }})" class="block py-1 border-bottom text-decoration-none pr-7">Delete</a></li>
                                        </ul>
                                    </div>
                                    <div class="w-1/2 mx-auto rounded-full px-1 py-1"
                                         style="background: linear-gradient(to right, #47afbe, #4addc4)">
                                        <div class="w-full px-0.5 py-0.5 rounded-full bg-white">
                                            <img
                                            src="{{ url('/storage/profile-image/').'/'.$user->accountInfo->avatar. '.jpg' }}"
                                            alt="{{ $user->accountInfo->avatar }}" class="rounded-full">
                                        </div>
                                    </div>
                                    <div class="w-full text-center pt-2 text-xs md:text-md">
                                        <p class="text-sm md:text-lg font-bold">{{ $user->user->name }}</p>
                                        <p>{{ '@' . $user->user->username }}</p>
                                        <p><li class="fas fa-map-marker-alt" style="color: #0bc2c8"></li>&nbsp;&nbsp;
                                        {{ $user->accountInfo->state . ',' . $user->accountInfo->country }}
                                        </p>
                                    </div>
                                    <div class="flex justify-content-center pt-2">
                                        <span class="px-1 py-0.5 text-xs rounded-md bg-yellow-300 text-white" style="height: 1.2rem">
                                            {{ number_format($user->accountInfo->rating, 1) }}
                                        </span>&nbsp;&nbsp;
                                        <span class="text-xs">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($user->accountInfo->rating > $i)
                                                    <i class="fas fa-star text-yellow-400"></i>
                                                @else
                                                    <i class="fas fa-star text-gray-400"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="ml-1 text-gray-700 font-bold text-xs">({{ $user->accountInfo->reviews }})</span>
                                    </div>
                                    <div class="flex justify-content-center pt-2">
                                        @if(count($user->category) > 0)
                                            @foreach($user->category as $category)
                                                <div class="w-1/3 mx-2 rounded-sm text-center py-1.5 text-xs md:text-md" style="background: {{ '#' . $category->back_color }}; color: {{ '#' . $category->text_color }}">{{ $category->category_name }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="md:px-3 pt-1 mt-2" style="border-top: 1px solid darkgrey">
                                        <div class="text-center w-full grid grid-cols-3 gap-2">
                                            <div style="border-right: 1px solid darkgrey">
                                                <p><i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i></p>
                                                <p class="mt-1 text-gray-700 tracking-tighte" style="font-size: 10px; line-height:10px;">
                                                  @switch($user->profile->instagram_follows)
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
                                            <div>
                                                <p><i class="fab fa-youtube text-red-400"></i></p>
                                                <p class="mt-1 text-gray-700 tracking-tighter" style="font-size: 10px; line-height:10px;">
                                                  @switch($user->profile->youtube_follows)
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
                                            <div style="border-left: 1px solid darkgrey">
                                                <p><i class="fab fa-tiktok text-gray-700"></i></p>
                                                <p class="mt-1 text-gray-700 tracking-tighter" style="font-size: 10px; line-height:10px;">
                                                  @switch($user->profile->tiktok_follows)
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
                                    <div class="w-full mt-8">
                                            <a class="block px-5 py-2 text-center text-decoration-none rounded-md text-white mx-auto text-xs md:text-md" onclick="loginAsUser({{ $user->user->id }})" style="background: #0bc2c8">Log in</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                      <div class="w-11/12 my-2 mx-auto">
                        {{ $users->appends($data)->links('pagination::bootstrap-4') }}   
                      </div>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div id="verifyModal" class="h-screen w-screen bg-gray-700 bg-opacity-75 fixed top-0 left-0 hidden">
        <div class="w-full h-full flex justify-center items-center">
            <div class="w-9/12 flex flex-col items-justify bg-white rounded-md shadow-md">
                <form action="{{ route('verifyUser') }}" method="get">
                    <div>
                        <input type="hidden" name="userId" id="userId">
                        <p class="text-sm text-center px-3 py-4">Are you sure you want to verify this user?</p>
                    </div>
                    <div class="w-full grid grid-cols-2 text-sm">
                        <div class="col-span-1">
                            <button class="block w-full py-3 rounded-bl-md text-white" type="submit" style="background:#0bc2c8">Yes</button>
                        </div>
                        <div class="col-span-1">
                            <button class="block w-full py-3" style="button" onclick="$('#verifyModal').fadeOut(200);">Cancel</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <div id="featureModal" class="h-screen w-screen bg-gray-700 bg-opacity-75 fixed top-0 left-0 hidden">
        <div class="w-full h-full flex justify-center items-center">
            <div class="w-9/12 flex flex-col items-justify bg-white rounded-md shadow-md">
                <form action="{{ route('featureUser') }}" method="get">
                    <div>
                        <input type="hidden" name="userId" id="userId">
                        <p class="text-sm text-center px-3 py-4">Are you sure you want to feature this user?</p>
                    </div>
                    <div class="w-full grid grid-cols-2 text-sm">
                        <div class="col-span-1">
                            <button class="block w-full py-3 rounded-bl-md text-white" type="submit" style="background:#0bc2c8">Yes</button>
                        </div>
                        <div class="col-span-1">
                            <button class="block w-full py-3" style="button" onclick="$('#featureModal').fadeOut(200);">Cancel</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <div id="unFeatureModal" class="h-screen w-screen bg-gray-700 bg-opacity-75 fixed top-0 left-0 hidden">
        <div class="w-full h-full flex justify-center items-center">
            <div class="w-9/12 flex flex-col items-justify bg-white rounded-md shadow-md">
                <form action="{{ route('unFeatureUser') }}" method="get">
                    <div>
                        <input type="hidden" name="userId" id="userId">
                        <p class="text-sm text-center px-3 py-4">Are you sure you want to unfeature this user?</p>
                    </div>
                    <div class="w-full grid grid-cols-2 text-sm">
                        <div class="col-span-1">
                            <button class="block w-full py-3 rounded-bl-md text-white" type="submit" style="background:#0bc2c8">Yes</button>
                        </div>
                        <div class="col-span-1">
                            <button class="block w-full py-3" style="button" onclick="$('#unFeatureModal').fadeOut(200);">Cancel</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <div id="deleteModal" class="h-screen w-screen bg-gray-700 bg-opacity-75 fixed top-0 left-0 hidden">
        <div class="w-full h-full flex justify-center items-center">
            <div class="w-9/12 flex flex-col items-justify bg-white rounded-md shadow-md">
                <form action="{{ route('deleteUser') }}" method="get">
                    <div>
                        <input type="hidden" name="userId" id="userId">
                        <p class="text-sm text-center px-3 py-4">Are you sure you want to delete this user?</p>
                    </div>
                    <div class="w-full grid grid-cols-2 text-sm">
                        <div class="col-span-1">
                            <button class="block w-full py-3 rounded-bl-md text-white" type="submit" style="background:#0bc2c8">Yes</button>
                        </div>
                        <div class="col-span-1">
                            <button class="block w-full py-3" style="button" onclick="$('#deleteModal').fadeOut(200);">Cancel</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <div id="blockModal" class="h-screen w-screen bg-gray-700 bg-opacity-75 fixed top-0 left-0 hidden">
        <div class="w-full h-full flex justify-center items-center">
            <div class="w-9/12 flex flex-col items-justify bg-white rounded-md shadow-md">
                <form action="{{ route('blockUser') }}" method="get">
                    <div>
                        <input type="hidden" name="userId" id="userId">
                        <p class="text-sm text-center px-3 py-4">Are you sure you want to block this user?</p>
                    </div>
                    <div class="w-full grid grid-cols-2 text-sm">
                        <div class="col-span-1">
                            <button class="block w-full py-3 rounded-bl-md text-white" type="submit" style="background:#0bc2c8">Yes</button>
                        </div>
                        <div class="col-span-1">
                            <button class="block w-full py-3" style="button" onclick="$('#blockModal').fadeOut(200);">Cancel</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <div id="loginModal" class="h-screen w-screen bg-gray-700 bg-opacity-75 fixed top-0 left-0 hidden">
        <div class="w-full h-full flex justify-center items-center">
            <div class="w-9/12 flex flex-col items-justify bg-white rounded-md shadow-md">
                <form action="{{ route('loginAsUser') }}" method="get">
                    <div>
                        <input type="hidden" name="login_user_id" id="login_user_id">
                        <p class="text-sm text-center px-3 py-4">Are you sure you want to login as this user?</p>
                    </div>
                    <div class="w-full grid grid-cols-2 text-sm">
                        <div class="col-span-1">
                            <button class="block w-full py-3 rounded-bl-md text-white" type="submit" style="background:#0bc2c8">Yes</button>
                        </div>
                        <div class="col-span-1">
                            <button class="block w-full py-3" type="button" onclick="$('#loginModal').fadeOut(200);">Cancel</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <div class="fixed top-5 right-5 px-5 py-3 bg-red-600 text-white rounded-lg shadow-md hidden" id="alert">
        <h3></h3>
    </div>
    <script>
        function showAlert(text) {
            console.log(text);
            $("div#alert h3").text(text);
            $("div#alert").fadeIn(200).delay(3000).fadeOut(200);
        }

        $("a.searchInfluencer").on('click', function () {
            $("a.searchBrand").removeClass('active');
            $(this).remove('active').addClass('active');
            $("input.accountType").val('influencer');
        });
        $("a.searchBrand").on('click', function () {
            $("a.searchInfluencer").removeClass('active');
            $(this).removeClass('active').addClass('active');
            $("input.accountType").val('brand');
        })

        function verifyUser(userId) {
            $("#verifyModal input#userId").val(userId);
            $("#verifyModal").fadeIn(200);
        }

        function featureUser(userId) {
            $("#featureModal input#userId").val(userId);
            $("#featureModal").fadeIn(200);
        }

        function deleteUser(userId) {
            $("#deleteModal input#userId").val(userId);
            $("#deleteModal").fadeIn(200);
        }

        function blockUser(userId) {
            $("#blockModal input#userId").val(userId);
            $("#blockModal").fadeIn(200);
        }

        function loginAsUser(userId) {
            $("#loginModal input#login_user_id").val(userId);
            $("#loginModal").fadeIn(200);
        }

        function unFeatureUser(userId) {
            $("#unFeatureModal input#userId").val(userId);
            $("#unFeatureModal").fadeIn(200);
        }
    </script>

    @if(session('msg'))
        <script>showAlert("{{ session('msg') }}");</script>
    @endif
@endsection
