@extends('layouts.app')

@section('content')
  <div class="w-full">
    <img src="{{ url('/storage/news-image/'.$news->back_img.'.jpg') }}" alt="{{ $news->back_img }}" class="w-full">
    <div class="px-2 md:px-3">
      <p class="text-lg md:text-xl font-bold py-3">{{ $news->project_title }}</p>
      <p class="text-md md:text-lg px-3 pb-5">{{ $news->description }}</p>
    </div>
  </div>
@endsection
