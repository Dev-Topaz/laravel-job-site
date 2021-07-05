<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @guest
    @else
        <meta name="api-token" content="{{ Auth::user()->api_token }}">
    @endguest

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <!-- pusher scripts-->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- bootstarp -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- croper js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
          integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
            integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/css/all.css') }}">
    <style>
        *{font-family:Poppins,sans-serif}input:focus,select:focus,textarea:focus{outline:0!important}.col-md-8{padding:0!important}a:hover{text-decoration:none;cursor:pointer}input[type=checkbox]:focus{border:none}.invalid-feedback{color:red}a.selected{background:#fff;border-radius:.25rem;color:#999}a.unselected{color:#999}.clearfix{display:table;content:'';clear:both}.menu_selected{color:#000;border-bottom:solid 4px #53b5c1}#collTab a.active,#mail-component #messageTab a.active,#searchTab a.active{border-bottom:solid 2px #4db3c1}#searchTab a.active{color:#4db3c1}a:focus{color:#000!important}#lg_tabMenu a.active{color:#000}#buttons button:hover{color:#d3d3d3}#buttons button:disabled:hover{color:#fff}.hasImage:hover section{background-color:rgba(5,5,5,.4)}.hasImage:hover button:hover{background:rgba(5,5,5,.45)}#overlay.draggedover{background-color:rgba(255,255,255,.7)}#overlay.draggedover i,#overlay.draggedover p{opacity:1}.group:hover .group-hover\:text-blue-800{color:#2b6cb0}img#image{display:block;max-width:100%}.preview{overflow:hidden;width:160px;height:160px;margin:10px;border:1px solid red}.modal-lg{max-width:1000px!important}#searchCategory label{font-family:Poppins,sans-serif}::-webkit-scrollbar{width:8px}::-webkit-scrollbar-track{background:#bbf3f1;border-radius:4px}::-webkit-scrollbar-thumb{background:#2bc5b5;border-radius:4px}a.payMethod.active div.payMethod{background:#52abb1!important;border:none}a.payMethod.active div.payMethod p{color:#fff}#star-rating a:hover{color:rgba(251,191,36,1)}.carousel-indicators{bottom:-40px}.carousel-indicators li{width:4px!important;height:4px!important;opacity:1!important;border-radius:50%;border:none;margin-bottom:10px;background-color:#0ac0c6}.carousel-indicators li.active{box-shadow:0 0 0 2px #0ac0c677}input:focus{border:#333!important}th:first-child{border-top-left-radius:10px}th:last-child{border-top-right-radius:10px}button, input, optgroup, select, textarea {padding:7px!important;}
    </style>
</head>
<body onunload="arrive()">
<div id="confirmModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <div class="w-8/12 mx-auto h-26 mt-4">
            <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Are you sure project is completed?</p>
        </div>
        <div class="w-full h-16" id="confirmBtn">
            <div class="w-full grid grid-cols-2 h-full">
                <div class="col-span-1 h-full">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white"
                        onclick="$('div#confirmModal').hide()">Cancel
                    </button>
                </div>
                <div class="col-span-1">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                        style="background:rgb(88,183,189)" onclick="onReleaseClick('releaseConfirm')">Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="giftConfirmModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <div class="w-8/12 mx-auto h-26 mt-4">
            <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Are you sure project is completed?</p>
        </div>
        <div class="w-full h-16" id="confirmBtn">
            <div class="w-full grid grid-cols-2 h-full">
                <div class="col-span-1 h-full">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white"
                        onclick="$('div#giftConfirmModal').hide()">Cancel
                    </button>
                </div>
                <div class="col-span-1">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                        style="background:rgb(88,183,189)" onclick="onReleaseClick('giftConfirm')">Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="uploadModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <img src="{{ asset('img/uploading.gif') }}" alt="uploading" class="w-48 mx-auto">
    </div>
</div>

<div id="deleteModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <img src="{{ asset('img/deleting.gif') }}" alt="deleting" class="w-48 mx-auto">
    </div>
</div>


<div id="reviewModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-68 bg-white absolute rounded-xl"
         style="top:50%; transform:translateY(-50%); left:50%; margin-left:-45.83333%;" id="modalBody">
        <div class="w-10/12 mx-auto h-26 mt-4">
            <p class="text-center text-lg md:text-xl font-bold">Congratulations!</p>
            <p class="text-center text-sm md:text-md text-gray-500 mt-3 mb-3">You have completed your project.<br/><span
                    class="font-bold text-gray-700">PLEASE LEAVE A REVIEW!</span><br/></p>
        </div>
        <div class="w-full h-16" id="confirmBtn">
            <div class="w-full grid grid-cols-2 h-full">
                <div class="col-span-1 h-full">
                    <a class="text-center w-full h-full block mx-auto px-4 rounded-bl-lg text-gray-500 text-md md:text-lg bg-white"
                       href="{{route('home')}}" style="line-height: 60px;">Cancel</a>
                </div>
                <div class="col-span-1">
                    @if (isset($requests))
                        <a class="text-center w-full h-full block mx-auto px-4 rounded-br-lg text-white font-bold text-md md:text-lg"
                           style="background:rgb(88,183,189); line-height:60px;"
                           href="{{route('leaveReview', ['request_id' => $requests->request_id])}}">Leave a Review</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<div>
    <nav class="shadow-xl">
        <!-- Mobile menu, show/hide based on menu state. -->
        @guest
        @else
            <div class="w-full fixed bottom-0 z-50">
                <div class="bg-white w-full md:max-w-7xl mx-auto object-center" id="mobile-menu">
                    <div class="px-1 py-1 grid grid-cols-5 sm:px-3 w-full border-t-xl"
                         style="border-top: 2px solid lightgrey;">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="{{ route('home') }}"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="fas fa-home"></i>
                        </a>

                        <a href="{{ route('inbox') }}"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center unread"
                           id="inbox">
                            <i class="far fa-envelope relative">
                                @if (($unread->inbox + $unread->requests) != 0)
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-2 rounded-full text-white text-xs bg-red-500"
                                        id="newInboxNotif"
                                        style="font-weight: 900; display:block">{{ $unread->inbox + $unread->requests }}</div>
                                @else
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-2 rounded-full text-white text-xs bg-red-500"
                                        id="newInboxNotif"
                                        style="font-weight: 900; display:none">{{ $unread->inbox + $unread->requests }}</div>
                                @endif
                            </i>
                        </a>

                        <a href="{{ route('task', ['item'=>'accepted']) }}" id="task"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="fas fa-link relative">
                                @if ($unread->task != 0)
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-3 text-white text-xs rounded-full bg-red-500"
                                        id="newTaskNotif" style="display: block">{{ $unread->task }}</div>
                                @else
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-3 text-white text-xs rounded-full bg-red-500"
                                        id="newTaskNotif" style="display: none">{{ $unread->task }}</div>
                                @endif
                            </i>
                        </a>

                        <a href="{{ route('search') }}"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="fas fa-search"></i>
                        </a>

                        <a data-toggle="modal" data-target="#profileModal"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="far fa-user"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="profileModal">
                <div class="modal-dialog" style="top: 50%; transform:translateY(-50%);">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Profile</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <ul class="w-11/12 mx-auto">
                                <li class="my-4"><a href={{ route('profile', ['username' => Auth::user()->username]) }}>
                                <i class="fas fa-user inline-block w-7"></i>
                                View Profile</a></li>
                                <li class="my-4"><a
                                        href={{ route('editProfile', ['username' => Auth::user()->username]) }}>
                                <i class="fas fa-user-edit inline-block w-7"></i>
                                Edit Profile</a></li>
                                <li class="my-4"><a href={{ route('balance') }}>
                                @if(Auth::user()->accountType == 'influencer')
                                <i class="fas fa-wallet inline-block w-7"></i>
                                Balance</a></li>
                                @endif
                                <li class="my-4"><a href={{ route('referrals') }}>
                                <i class="fas fa-sync-alt inline-block w-7"></i>
                                Referrals</a></li>
                                <li class="my-4"><a href={{ route('saved') }}>
                                <i class="fas fa-heart inline-block w-7"></i>
                                Saved</a></li>
                                <li class="my-4"><a href="{{ route('accountSetting') }}">
                                <i class="fas fa-cog inline-block w-7"></i>
                                Account Settings</a></li>
                            </ul>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <form action="{{ route('logout') }}" id="logout-form" method="post">
                                {{ csrf_field() }}
                                <button type="button" onclick="logout()"><i
                                        class="inline-block w-7 fas fa-sign-out-alt"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loggedIn" class="loggedIn" hidden></div>
        @endguest
    </nav>
    @yield('content')
</div>
<script>
  let qualityCount = 0;var comCount=0;var experCount=0;var professCount=0;var againCount=0
    const page = {{ $page ?? 0 }};
    const currency = '{{ $currency ?? '' }}';

    function showProfileModal(){"none"==$("div#profileModal").css("display")?$("div#profileModal").show():$("div#profileModal").hide()}$(document).ready(function(){var e=$("#mobile-menu a").eq(page-1);e.addClass("menu_selected"),$("#lg_tabMenu a").eq(page-1).addClass("active"),$("#user-menu-content").css("display","none"),$("#user-menu").click(function(){"block"==$("#user-menu-content").css("display")?$("#user-menu-content").css("display","none"):$("#user-menu-content").css("display","block")}),0===page&&checkSession(),$("#searchTab a").click(function(){$("#searchTab a.active").removeClass("active"),$(this).addClass("active");var e=$(this).attr("id");$("div.full-view").hide(),$("div.grid-view").hide(),$("div."+e).show()}),$("#gallery .delete").click(function(){$(this).parent().remove()}),$("a.payMethod").click(function(){$("a.payMethod.active").removeClass("active"),$(this).addClass("active"),"gift"==$(this).attr("id")?($("div#budgetColumn").hide(),$("select#price").val(""),$("input#price").val(""),$("input#giftInput").val(1)):($("input#giftInput").val(""),$("div#budgetColumn").show())}),$("#star-rating a").click(function(){$(this).attr("class").search("text-gray-400")&&$(this).removeClass("text-gray-400").addClass("text-yellow-400");var e=$(this).attr("class").split("star-")[1][0];switch($(this).parent().attr("id")){case"Quality":qualityCount=e;break;case"Communication":comCount=e;break;case"Expertise":experCount=e;break;case"Professionalism":professCount=e;break;case"Would":againCount=e}$(this).prevAll().removeClass("text-gray-400").addClass("text-yellow-400"),$(this).nextAll().removeClass("text-yellow-400").addClass("text-gray-400"),var t=(parseInt(qualityCount)+parseInt(comCount)+parseInt(experCount)+parseInt(professCount)+parseInt(againCount))/5;$("input#rating").val(t)})}),Pusher.logToConsole=!0;var pusher=new Pusher("da7cd3b12e18c9e2e461",{cluster:"eu"});
</script>

@guest
@else
    <script>
        $(document).ready(function () {
            const transactionHeight = window.innerHeight - 475;
            $("div#transaction").css('height', transactionHeight + 'px');
            if (page == 2) {
                var unreadInbox = {{ $unread->inbox }};
                var unreadRequest = {{ $unread->requests }};
                // console.log(unreadInbox, unreadRequest);
                if (unreadInbox > 0) {
                    $("a#inbox div#inboxNotif").show();
                }
                if (unreadRequest > 0) {
                    $("a#requests div#requestNotif").show();
                }
            }
            if (page == 5 && currency != '') {
              // console.log(currency);
              $("select#balance_currency").val(currency.toLowerCase());
              showBalance();
            }
        });
        var channel = pusher.subscribe('fluenser-channel');
        channel.bind('fluenser-event', function (data) {
            // console.log('newRequest');
            if (data.trigger == 'newRequest') {
                // console.log(data);
                if (data.request.send_id == "{{ Auth::user()->id}}" || data.request.receive_id == "{{Auth::user()->id}}") {
                    if ($("#newInboxNotif").css('display') == 'block') {
                        var count = $("#newInboxNotif").text();
                        // console.log(count);
                        $("#newInboxNotif").text(parseInt(count) + 1);
                    } else {
                        $("#newInboxNotif").text(1);
                        $("#newInboxNotif").show();
                    }

                    if ($("a#requests div#requestNotif").css('display') != 'block') {
                        $("a#requests div#requestNotif").css('display', 'block');
                    }
                }
            }

            if (data.trigger == 'newRequestChat') {
                if (data.requestChat.receive_id == "{{Auth::user()->id}}") {
                    // console.log(data);

                    if ($("#newInboxNotif").css('display') == 'block') {
                        var count = $("#newInboxNotif").text();
                        // console.log(count);
                        if ($("div#" + data.requestChat.request_id + " p span").css('display') == 'none') {
                            $("#newInboxNotif").text(parseInt(count) + 1);
                        }
                    } else {
                        $("#newInboxNotif").text(1);
                        $("#newInboxNotif").show();
                    }
                    if ($("a#requests div#requestNotif").css('display') != 'block') {
                        $("a#requests div#requestNotif").css('display', 'block');
                    }
                    $("div#" + data.requestChat.request_id + " p span").show();
                }
            }

if("newInboxChat"==data.trigger&&"{{Auth::user()->id}}"==data.inboxInfo.receive_id){if("block"==$("#newInboxNotif").css("display")){var count=$("#newInboxNotif").text();"none"==$("div#"+data.inboxInfo.inbox_id+" p span").css("display")&&$("#newInboxNotif").text(parseInt(count)+1)}else $("#newInboxNotif").text(1),$("#newInboxNotif").show();"block"!=$("a#inbox div#inboxNotif").css("display")&&$("a#inbox div#inboxNotif").css("display","block"),$("div#"+data.inboxInfo.inbox_id+" p span").show()}

            if (data.trigger == 'newTask') {
                if (data.request.receive_id == "{{Auth::user()->id}}") {
                    if ($("#newTaskNotif").css('display') == 'block') {
                        var count = $("#newTaskNotif").text();
                        $("#newTaskNotif").text(parseInt(count) + 1);
                    } else {
                        $("#newTaskNotif").text(1);
                        $("#newTaskNotif").show();
                    }
                }
            }
        });

window.addEventListener('onbeforeunload', function(e) {
    arrive();
}, false);

        function arrive(){var o="{{ url('/') }}/api/userLogOut?api_token=";o+=$("meta[name=api-token]").attr("content"),$.ajax({url:o,type:"GET",headers:{Accept:"application/json"},success:function(o){},error:function(o,t,n){}})}function logout(){var o="{{ url('/') }}/api/userLogOut?api_token=";o+=$("meta[name=api-token]").attr("content"),$.ajax({url:o,type:"GET",headers:{Accept:"application/json"},success:function(o){},error:function(o,t,n){}}),$("form#logout-form").submit()}

    </script>
@endguest
</body>
</html>
