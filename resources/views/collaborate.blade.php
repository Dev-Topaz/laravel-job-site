@extends('layouts.app')
@section('content')
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <span><a href="{{ route('search') }}" class="text-white"><i class="fas fa-chevron-left"></i></a></span>
    <span class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('COLLABORATE') }}</span>
  </div>
</header>
  <main class="w-full md:max-w-7xl mx-auto">
    <div class="w-full md:max-w-7xl mx-auto sm:px-6 lg:px-8" id="collaborate" style="overflow: auto">
      <!-- Replace with your content -->
        <div class="bg-white w-11/12 mx-auto my-3 md:max-w-lg pb-20">
          <div class="w-3/5 mx-auto rounded-full" style="background: linear-gradient(to right, #06ebbe, #1277d3); padding:6px;">
            <div class="w-full rounded-full bg-white px-1 py-1">
              <img src="{{ url('/storage/profile-image/'.$influencerInfo->avatar.'.jpg') }}" alt="$influencerInfo->avatar" class="w-full mx-auto rounded-full">
            </div>
          </div>
          <p class="text-center text-black text-lg md:text-xl font-bold">
            {{ $influencerInfo->name }}
          </p>
          <p class="text-center text-gray-500 text-sm md:text-md">
            {{ '@' . $influencerInfo->username }}
          </p>
          <div class="w-full mt-6">
            <form action={{ route('saveRequest') }} method="post" id="requestForm">
              {{ csrf_field() }}
              <input type="text" name="title" id="title" class="w-full rounded-lg bg-gray-100 border-none my-2 @error('title') is-invalid @enderror" placeholder="Project Title" value="{{ old('title') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <textarea name="detail" id="detail" class="w-full rounded-lg bg-gray-100 border-none my-2 @error('detail') is-invalid @enderror" placeholder="Describe your project" rows='5'>{{ old('detail') }}</textarea>
                @error('detail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <div class="attach w-full rounded-lg my-2">
                {{-- file upload --}}
                <div class="w-full min-h-lg sm:py-8">
                  <main class="mx-auto max-w-screen-lg h-full">
                    <!-- file upload modal -->
                    <article aria-label="File Upload Modal" class="relative h-full flex flex-col bg-white rounded-lg">

                      <!-- scroll area -->
                      <section class="h-full w-full h-full flex flex-col">
                        <header class="border-dashed border-2 border-gray-200 py-8 flex flex-col justify-center items-center rounded-lg">
                          <input id="hidden-input" type="file" name="image" class="image hidden" />
                          <a id="button" class="mt-2 rounded-full px-3 py-1 text-white" style="background: #879a9b;">
                            <i class="fas fa-plus-circle text-gray-500 bg-white rounded-full"></i>
                            Attach File
                          </a>
                          <p class="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center underline text-xs md:text-sm text-gray-300">
                            Max size is 20MB.
                          </p>
                          <ul id="gallery" class="w-11/12 mx-auto">
                          </ul>
                        </header>
                      </section>

                      <!-- sticky footer -->
                    </article>
                  </main>
                </div>
                <div class="w-full mx-auto my-5">
                  <p class="text-center text-gray-500 text-sm md:text-md mb-5">
                    How would you like to compensate the influencer?
                  </p>
                  <a class="payMethod active" id="money">
                    <div class="payMethod float-left" style="width: 90px; height: 90px; border-radius:50%; background:#eee; border: 1px solid lightgray; padding:15px">
                      <p class="text-3xl text-gray-500 text-center" style="line-height: 35px">
                        <img src="{{ asset('img/dollar.png') }}" style="width:32px; margin:auto;">
                      </p>
                      <p class="text-center text-xs text-gray-500" style="line-height: 25px">
                        Money
                      </p>
                    </div>
                  </a>
                  <a class="payMethod" id="both">
                    <div class="payMethod float-right mx-auto" style="width: 90px; height: 90px; border-radius:50%; background:#eee; border: 1px solid lightgray; padding:15px">
                      <p class="text-3xl text-gray-500 text-center text-gray-500" style="line-height: 35px">
                          <img src="{{ asset('img/bag_dollar.png') }}" style="width: 37px; margin:auto;">
                      </p>
                      <p class="text-center text-xs  text-gray-500" style="line-height: 25px">
                        Both
                      </p>
                    </div>
                  </a>
                  <a class="payMethod" id="gift">
                    <div class="payMethod mx-auto" style="width: 90px; height: 90px; border-radius:50%; background:#eee; border: 1px solid lightgray; padding:15px">
                      <p class="text-3xl text-gray-500 text-center text-gray-500" style="line-height: 35px">
                          <img src="{{ asset('img/bag.png') }}" style="width: 37px; margin:auto;">
                      </p>
                      <p class="text-center text-xs  text-gray-500" style="line-height: 25px">
                        Gift
                      </p>
                    </div>
                  </a>
                  <div class="clearfix"></div>
                </div>
                <div class="w-full" id="budgetColumn">
                  <label for="price" class="block text-sm font-medium text-gray-500">Budget</label>
                  <div class="mt-1 relative rounded-md shadow-sm flex" id="budget">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    </div>
                    <select onchange="onClickCustom()" name="price" id="price" class="block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') is-invalid @enderror" placeholder="0.00" style="height: 38px; -webkit-appearance: menulist; border: 1px solid lightgrey;" value="{{ old('price') }}">
                      <option value="10-30">10-30</option>
                      <option value="30-50">30-250</option>
                      <option value="250-750">250-750</option>
                      <option value="750-1500">750-1500</option>
                      <option id="custom" value="custom">Customise</option>
                    </select>
                    <div class="flex items-center">
                      <select id="currency" name="currency" class="h-full py-0 pl-2 pr-7 text-black sm:text-sm rounded-r-md" style="-webkit-appearance: menulist; border: 1px solid lightgrey;">
                        <option value="gbp">GBP</option>
                        <option value="usd">USD</option>
                        <option value="aed">AED</option>
                        <option value="aud">AUD</option>
                        <option value="bgn">BGN</option>
                        <option value="brl">BRL</option>
                        <option value="cad">CAD</option>
                        <option value="chf">CHF</option>
                        <option value="czk">CZK</option>
                        <option value="dkk">DKK</option>
                        <option value="eur">EUR</option>
                        <option value="gbp">GBP</option>
                        <option value="hkd">HKD</option>
                        <option value="huf">HUF</option>
                        <option value="inr">INR</option>
                        <option value="jpy">JPY</option>
                        <option value="mxn">MXN</option>
                        <option value="myr">MYR</option>
                        <option value="nok">NOK</option>
                        <option value="pln">PLN</option>
                        <option value="ron">RON</option>
                        <option value="sek">SEK</option>
                        <option value="sgd">SGD</option>
                      </select>
                      <input type="text" name="files" id="files" hidden>
                    </div>
                  </div>
                </div>
              </div>
              @error('price')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <input type="text" name="brand_id" id="brand_id" value="{{ $accountInfo->id }}" hidden>
              <input type="text" name="influencer_id" id="influencer_id" value="{{ $influencerInfo->id }}" hidden>
              <input type="hidden" name="gift" id="giftInput" value="">
              <textarea name="images" id="images" cols="30" rows="10" hidden></textarea>
              <button id="sendRequest" type="submit" class="w-full py-2 text-white rounded-md text-md md:text-lg font-bold mt-5" style="background: #0ac2c8">Send</button>
            </form>
          </div>
        </div>
    </div>
  </main>

  {{-- upload modal --}}
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg w-10/12 mx-auto" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">??</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
              <div class="row">
                  <div class="col-md-8">
                      <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                  </div>
                  <div class="col-md-4">
                      <div class="preview"></div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="crop">Crop</button>
        </div>
      </div>
    </div>
  </div>

  <script>
var cropper,filesValue,$modal=$("#modal"),image=document.getElementById("image");function onClickCustom(){if("custom"==$("select#price").val()){$("select#price").remove();var e=$("<input name='price' type='text' id='price' value='{{ old('price') }}' class='block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') is-invalid @enderror' placeholder='0.00'/>");$("div#budget").append(e)}}const hidden=document.getElementById("hidden-input");document.getElementById("button").onclick=(()=>hidden.click()),hidden.onchange=(e=>{var l,t,r=e.target.files,a=function(e){image.src=e,$modal.modal("show")};r&&r.length>0&&(t=r[0],URL?a(URL.createObjectURL(t)):FileReader&&((l=new FileReader).onload=function(e){a(l.result)},l.readAsDataURL(t)))}),$modal.on("shown.bs.modal",function(){cropper=new Cropper(image,{aspectRatio:1,viewMode:3,preview:".preview"})}).on("hidden.bs.modal",function(){cropper.destroy(),cropper=null}),$("#crop").click(function(){canvas=cropper.getCroppedCanvas({width:1024,height:1024}),canvas.toBlob(function(e){url=URL.createObjectURL(e);var l=new FileReader;l.readAsDataURL(e),l.onloadend=function(){var e=l.result;$("ul#gallery").prepend('<li class="float-left w-1/2 md:w-1/4 px-2 py-2 relative"><img src="" class="w-full rounded-lg"></li>'),$("ul#gallery li:first-child img").attr("src",e),$("ul#gallery li:first-child").append('<a class="delete absolute -top-1 -right-1 z-10 h-6 w-6 text-center bg-red-600 rounded-full" onclick="$(this).parent().remove()"><i class="text-gray-100 leading-6 hover:text-gray-700 fa fa-times"></i></a>'),$modal.modal("hide")}})}),$("button#sendRequest").click(function(){var e=$("ul#gallery img"),l=[];if(e.length>0)for(let t=0;t<e.length;t++){const r=e[t];l.push(r.src)}$("textarea#images").val(JSON.stringify(l))});

  </script>

@endsection
