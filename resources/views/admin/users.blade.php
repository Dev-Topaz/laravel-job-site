@extends('layouts.admin')
@section('content')
  <style>
    span[aria-current='page'] {
      background-color: #1a202c;
      color: white;
    }
    input {
        border: 1px solid lightgrey !important;
        padding: 8px 12px !important;
    }
  </style>
  <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
    <p class="italic text-lg text-white font-bold leading-8 pr-2" style="font-family: 'Josefin Sans', sans-serif;">@if($accountType == 'brand'){{ __('Brands') }}@else{{ __('Influencers') }}@endif</p>
  </div>
  <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
    <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">@if($accountType == 'brand'){{ __('Brands') }}@else{{ __('Influencers') }}@endif</h2>
  </div>
  <div class="w-full px-3 py-3 md:float-left md:w-3/4 lg:w-4/5 xl:w-5/6">
  <div id="projects">
    <table class="w-full">
      <thead class="w-full bg-gray-300 text-gray-500">
      <tr class="w-full">
        <th style="width:10%" class="py-2 pl-2 rounded-l-md">No</th>
        <th style="width:25%" class="py-2 pl-2">Full Name</th>
        <th style="width:25%" class="py-2 pl-2">Username</th>
        <th style="width:25%" class="py-2 pl-2">Email</th>
        <th style="width:15%" class="py-2 pl-2">Action</th>
      </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $rank ++ }}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $user->user->name }}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $user->user->username }}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $user->user->email}}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm"><a  onclick="loginAsUser({{ $user->user->id }})" class="block border border-gray-400 rounded-md px-3 py-2">Log in</a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="w-full">
    {{ $users->links('pagination::bootstrap-4') }}  
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
  <script type="text/javascript">
    function loginAsUser(userId) {
      $("#loginModal input#login_user_id").val(userId);
      $("#loginModal").fadeIn(200);
    }
  </script>
  @endsection
