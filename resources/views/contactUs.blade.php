<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- bootstarp -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
  </head>
<body>
<main>
    <div class="max-full md:max-w-xl mx-auto py-6 sm:px-6 lg:px-8 mt-10">
    <div class="w-full">
        <a href="{{route('welcome')}}" class="block mx-auto mb-10" style="max-width: 150px;">
            <img class="w-full" width="150" height="45" src="{{ asset('img/logo.webp') }}" alt="logo">
        </a>
    </div>
        <div class="w-11/12 mx-auto bg-gray-100 rounded-2xl py-3" style="font-family: 'Poppins', sans-serif;">
            <div class="w-11/12 mx-auto">
                <!-- Replace with your content -->
                <p class="text-center text-2xl">Contact Us</p>
                <hr>
                <div class="py-6 sm:px-0 w-full mx-auto">
                  <form method="POST" action="{{ route('submitContactUs') }}" class="mx-auto">
                      @csrf
                      <label class="block mb-8">
                          <input id="name" type="text" class="h-10 form-input mt-2 block w-full @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name" style="border:1px solid #999; padding:25px 15px;">
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </label>
                      <label class="block mb-8">
                          <input id="email" type="email" class="h-10 form-input mt-2 block w-full @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" style="border:1px solid #999; padding:25px 15px;">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </label>
                      <label class="block mb-6">
                          <input id="subject" type="text" class="h-10 form-input mt-2 block w-full @error('subject') is-invalid @enderror" name="subject" required placeholder="Subject" style="border:1px solid #999; padding: 25px 15px;">
                          @error('subject')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </label>
                      <label class="block mb-6">
                          <textarea id="content" class="form-input mt-2 block w-full @error('content') is-invalid @enderror" name="content" required placeholder="How can we help?" rows="5" style="border:1px solid #999; padding: 15px 15px; resize: none;"></textarea>
                          @error('content')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </label>
                      <div class="flex mt-6 w-2/3 mx-auto">
                          <button type="submit" class="w-full appearance-none text-white text-lg md:text-xl font-semibold tracking-wide rounded hover:bg-blue-900" style="background:#0ac2c8; padding:15px;"> {{ __('Send') }} </button>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>