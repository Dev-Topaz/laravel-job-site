@extends('layouts.app')
@section('content')
  <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
  <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
  <style type="text/css">
    input,select,textarea{border:1px solid #d3d3d3!important}#social-media-links input[type=checkbox]{display:none}#social-media-links input[type=checkbox]+label{background-image:url("{{ asset('img/checkbox_checked.png') }}");background-size:cover;height:16px;width:16px;margin:0}#social-media-links input[type=checkbox]:checked+label{background-image:url("{{ asset('img/checkbox.png') }}");background-size:cover;height:16px;width:16px;margin:0}
  </style>
  <header class="bg-white">
    <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
      <p class="italic text-lg md:text-xl text-white font-bold leading-8"
         style="font-family: 'Josefin Sans', sans-serif;">{{ __('EDIT PROFILE') }}</p>
    </div>
  </header>
  <main>
    <input type="file" name="image" id="hidden-input" hidden>
    <div class="w-full md:max-w-7xl mx-auto mb-12">
      <form method="post" action="{{route('updateProfile', ['user_id' => $accountInfo->id])}}">
      {{ csrf_field() }}
      <!-- Replace with your content -->
        <div class="bg-white">
          <div class="w-full">
            <div class="relative overflow-hidden">
              <a class="block absolute top-4 right-2 rounded-full h-8 w-8 bg-white text-center"
                 style="box-shadow: 0 0 15px #999" onclick="editImg('top')">
                <p class="leading-8 text-lg" style="color: #4addc4">
                  <i class="fas fa-pencil-alt"></i>
                </p>
              </a>
              <img src="{{ url('/') . '/storage/profile-image/'.$profile->top_img.'.jpg'}}"
                   alt="{{ $profile->top_img }}" class="w-full" id="top-image">
            </div>
          </div>
          <div class="w-11/12 mx-auto relative -top-32 bg-white rounded-lg pb-3 pt-1"
               style="box-shadow: 0 0 10px 0 #999">
            <div class="w-1/3 absolute py-1 px-1 bg-white rounded-full"
                 style="top:0; left:50%; transform: translate(-50%, -60%);box-shadow:0 0 8px #333">
              <label for="round_img" class="hidden"></label><textarea name="round_img" id="round_img"
                                                                      hidden></textarea>
              <img class="rounded-full w-full" id="round-image"
                   src="{{ url('/') . '/storage/profile-image/'.$profile->round_img.'.jpg'}}"
                   alt="{{$profile->round_img}}">
              <a class="absolute block w-8 h-8 bg-white rounded-full text-center"
                 style="right:5%; bottom:5%;box-shadow: 0 0 15px #999" onclick="editImg('round')">
                <p class="leading-8 text-lg" style="color: #4addc4">
                  <i class="fas fa-camera"></i>
                </p>
              </a>
            </div>
            <div class="w-11/12 mx-auto" style="margin-top:15vw">
              <label for="name" class="text-gray-500 text-sm md:text-md">Name</label>
              <input type="text" name="name" id="name" style="box-shadow:0 0 10px 0 gray"
                     class="block w-full border-none rounded text-gray-700 font-semibold mb-3 h-10 shadow-inner @error('name') is-invalid @enderror"
                     value="{{ $accountInfo->name }}">
              @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

              <label for="username" class="text-gray-500 text-sm md:text-md">Username</label>
              <input type="text" name="username" id="username" style="box-shadow:0 0 10px 0 gray"
                     class="block w-full border-none rounded text-gray-700 font-semibold mb-3 h-10 shadow-inner @error('username') is-invalid @enderror"
                     value="{{ $accountInfo->username }}">
              @error('username')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

              <label for="state" class="text-gray-500 text-sm md:text-md">City</label>
              <input type="text" name="state" id="state" style="box-shadow:0 0 10px 0 gray"
                     class="block w-full border-none rounded text-gray-700 font-semibold mb-3 h-10 shadow-inner @error('state') is-invalid @enderror"
                     value="{{ $accountInfo->state }}">
              @error('city')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

              <label for="country" class="text-gray-500 text-sm md:text-md">Country</label>
              <select name="country" id="country" style="box-shadow:0 0 10px 0 gray"
                      class="block w-full border-none rounded text-gray-700 font-semibold mb-3 h-10 shadow-inner @error('state') is-invalid @enderror">
                @foreach ($countries as $country)
                  @if (strtoupper(trim($country->name)) == strtoupper(trim($accountInfo->country)))
                    <option value={{ $country->id }} selected>{{ $country->name }}</option>
                  @else
                    <option value={{ $country->id }}>{{ $country->name }}</option>
                  @endif
                @endforeach
              </select>

              <label for="introduction" class="text-gray-500 text-sm md:text-md">Bio</label>
              <textarea type="text" style="resize: none;" name="introduction" id="introduction"
                        class="bg-gray-100 block w-full border-none rounded h-28 text-gray-700 font-semibold mb-3 h-10 shadow-inner @error('introduction') is-invalid @enderror"
                        onkeyup="displayLength()">{{ $profile->introduction }}</textarea>
              <div>
                <div class="float-right text-xs text-gray-500">
                  <span id="intro_length">0</span><span>/140</span>
                </div>
                <div class="clearfix"></div>
              </div>
              @error('introduction')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

              <label for="portfolio" class="text-gray-500 text-sm md:text-md">Add Your Portfolio
                Images</label>
              <div
                class="bg-gray-100 block w-full border-none rounded text-gray-700 font-semibold mb-3 shadow-inner px-2 py-1 relative"
                style="min-height: 4rem">
                <div class="float-right w-20 text-center absolute"
                     style="top: 50%; transform:translateY(-50%); right: 10px">
                  <a onclick="editImg('portfolio')">
                    <img src="{{ asset('img/add-image.png') }}" alt="add-image" style="width: 36px;margin: auto;">
                    <p class="text-xs md:text-sm text-gray-500">Add Image</p>
                  </a>
                </div>
                <div id="portfolio-gallery" class="mr-20">
                  @foreach ($portfolios as $portfolio)
                    <div id="gallery-item" class="float-left mr-3 my-2 relative">
                      <img
                        src="{{ url('/storage/profile-image').'/'.$portfolio->slide_img.'.jpg' }}"
                        alt="{{ $portfolio->slide_img }}" class="rounded-sm"
                        style="width: 65px; box-shadow:0 0 5px #333">
                      <a
                        class="block absolute w-5 h-5 text-center rounded-full bg-red-600 text-white text-xs -top-2 -right-2"
                        onclick="removeImage($(this), 'portfolio')"><span
                          class="leading-5">X</span></a>
                    </div>
                  @endforeach
                </div>
                <div class="clearfix"></div>
              </div>

              @if ($accountInfo->accountType == 'influencer')
                <label for="partnership" class="text-gray-500 text-sm md:text-md">Add brand logos you
                  have worked with</label>
                <div
                  class="bg-gray-100 block w-full border-none rounded text-gray-700 font-semibold mb-3 shadow-inner px-2 py-1 relative"
                  style="min-height: 3rem">
                  <div class="float-right w-20 text-center absolute"
                       style="top: 50%; transform:translateY(-50%); right: 10px">
                    <a onclick="editImg('partnership')">
                      <img src="{{ asset('img/add-image.png') }}" alt="add-image" style="width: 36px;margin: auto;">
                      <p class="text-xs md:text-sm text-gray-500">Add Image</p>
                    </a>
                  </div>
                  <div id="partnership-gallery" class="mr-20">
                    @foreach ($partnerships as $partnership)
                      <div id="gallery-item" class="float-left mr-3 my-2 relative">
                        <img
                          src="{{ url('/storage/partnership-image').'/'.$partnership->partnership_img.'.jpg' }}"
                          alt="{{ $partnership->partnership_img }}" class="rounded-sm"
                          style="width: 65px; box-shadow:0 0 5px #333">
                        <a
                          class="block absolute w-5 h-5 text-center rounded-full bg-red-600 text-white text-xs -top-2 -right-2"
                          onclick="removeImage($(this), 'partnership')"><span class="leading-5">X</span></a>
                      </div>
                    @endforeach
                  </div>
                  <div class="clearfix"></div>
                </div>
              @endif


              <label for="categories" class="text-gray-500 text-sm md:text-md">Choose 2 categories that
                describe your content the best</label>
              <div
                class="bg-gray-100 block w-full border-none rounded text-gray-700 font-semibold shadow-inner px-2 py-3 relative mb-3">
                <div class="relative">
                  <input type="text" id="categories"
                         class="block w-11/12 mx-auto rounded-full text-gray-700 text-sm md:text-md"
                         style="border: 1px solid lightgray" placeholder="Categories" readonly>
                  <div class="absolute" style="top: 10px; right:30px;">
                    <a onclick="categoryToggle()" id="categoryToggle"><i
                        class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
                <div class="w-11/12 mx-auto py-2 px-3 my-3 h-24 overflow-auto rounded-xl hidden"
                     id="categories_box" style="box-shadow: 0 0 8px 0 #999">
                  @foreach ($categories as $category)
                    <?php $a = 0; ?>
                    @foreach ($selectedCategories as $item)
                      @if ($category->category_name == $item->category_name)
                        <?php $a++; ?>
                      @endif
                    @endforeach
                    @if ($a == 1)
                      <label for="category" class="text-gray-700 text-xs md:text-sm"><input
                          type="checkbox" onclick="checkboxClick(this)"
                          class="rounded border-gray-400 bg-gray-100" name="category[]"
                          id="category" value="{{ $category->id }}"
                          checked>&nbsp;&nbsp;{{ $category->category_name }}</label><br/>
                    @else
                      <label for="category" class="text-gray-700 text-xs md:text-sm"><input
                          type="checkbox" onclick="checkboxClick(this)"
                          class="rounded border-gray-400 bg-gray-100" name="category[]"
                          id="category"
                          value="{{ $category->id }}">&nbsp;&nbsp;{{ $category->category_name }}
                      </label><br/>
                    @endif
                  @endforeach
                </div>
              </div>

              <label for="categories" class="text-gray-500 text-sm md:text-md">Add 3 social media
                links to your profile</label>
              <div id="social-media-links"
                   class="bg-gray-100 block w-full border-none rounded text-gray-500 font-semibold shadow-inner px-2 py-1 relative pt-3 mb-3">
                <div class="w-11/12 flex align-items-center mb-3 mx-auto">
                  <input type="checkbox" name="instagram_check[]" id="instagram_check" value="checked" onclick="checkSocialLink($(this))" @if($profile->instagram_check == 1) checked @endif />
                  <label for="instagram_check"></label>
                  <button type="button"
                          class="block py-1 w-10/12 mx-auto rounded-xl text-sm bg-white"
                          style="box-shadow: 0 0 8px 0 #999" onclick="$('div#instagram_block').toggle();">
                    <i class="fab fa-instagram"></i>&nbsp;&nbsp;&nbsp;Add Instagram
                  </button>
                </div>
                <div class="w-11/12 mx-auto grid grid-cols-12 mb-3 hidden" id="instagram_block">
                  <div class="col-span-12 md:col-span-11">
                    <label for="instagram-link"></label><input type="text" name="instagram-link"
                                                               id="instagram-link"
                                                               class="text-gray-700 rounded w-full my-2 border-none text-sm md:text-md py-1 px-2"
                                                               style="box-shadow: 0 0 8px 0 #999"
                                                               placeholder="Instagram.com/username"
                                                               value="{{$profile->instagram}}">
                    <label for="instagram-follow"></label><select name="instagram-follow"
                                                                  id="instagram-follow"
                                                                  class="text-gray-700 rounded-full w-full my-2 border-none text-sm md:text-md py-1 px-2"
                                                                  style="box-shadow: 0 0 8px 0 #999">
                      <option>How many followers?</option>
                      <option value="11" @if($profile->instagram_follows == 11) selected @endif>
                        1k-10k
                      </option>
                      <option value="60" @if($profile->instagram_follows == 60) selected @endif>
                        10k-50k
                      </option>
                      <option value="600" @if($profile->instagram_follows == 600) selected @endif>
                        100k-500k
                      </option>
                    </select>
                  </div>
                </div>
                <div class="w-11/12 flex align-items-center mb-3 mx-auto">
                  <input type="checkbox" name="youtube_check[]" id="youtube_check" value="checked" onclick="checkSocialLink($(this))" @if($profile->youtube_check == 1) checked @endif>
                  <label for="youtube_check"></label>
                  <button type="button"
                          class="block py-1 w-10/12 mx-auto rounded-xl text-sm bg-white"
                          style="box-shadow: 0 0 8px 0 #999" onclick="$('div#youtube_block').toggle();">
                    <i class="fab fa-youtube"></i>&nbsp;&nbsp;&nbsp;Add Youtube
                  </button>
                </div>
                <div class="w-11/12 mx-auto grid grid-cols-12 mb-3 hidden" id="youtube_block">
                  <div class="col-span-12 md:col-span-11">
                    <input type="text" name="youtube-link" id="youtube-link"
                           class="text-gray-700 rounded w-full my-2 border-none text-sm md:text-md py-1 px-2"
                           style="box-shadow: 0 0 8px 0 #999" placeholder="Youtube.com/username"
                           value="{{$profile->youtube}}">
                    <select name="youtube-follow" id="youtube-follow"
                            class="text-gray-700 rounded-full w-full my-2 border-none text-sm md:text-md py-1 px-2"
                            style="box-shadow: 0 0 8px 0 #999">
                      <option>How many followers?</option>
                      <option value="11" @if($profile->youtube_follows == 11) selected @endif>
                        1k-10k
                      </option>
                      <option value="60" @if($profile->youtube_follows == 60) selected @endif>
                        10k-50k
                      </option>
                      <option value="600" @if($profile->youtube_follows == 600) selected @endif>
                        100k-500k
                      </option>
                    </select>
                  </div>
                </div>
                <div class="w-11/12 flex align-items-center mb-3 mx-auto">
                  <input type="checkbox" name="tiktok_check[]" id="tiktok_check" value="checked" onclick="checkSocialLink($(this))" @if($profile->tiktok_check == 1) checked @endif>
                  <label for="tiktok_check"></label>
                  <button type="button"
                          class="block py-1 w-10/12 rounded-xl text-sm bg-white mx-auto"
                          style="box-shadow: 0 0 8px 0 #999" onclick="$('div#tiktok_block').toggle();">
                    <i class="fab fa-tiktok"></i>&nbsp;&nbsp;&nbsp;Add Tiktok
                  </button>
                </div>
                <div class="w-11/12 mx-auto grid grid-cols-12 mb-2 hidden" id="tiktok_block">
                  <div class="col-span-12 md:col-span-11">
                    <input type="text" name="tiktok-link" id="tiktok-link"
                           class="text-gray-700 rounded w-full my-2 border-none text-sm md:text-md py-1 px-2"
                           style="box-shadow: 0 0 8px 0 #999" placeholder="TikTok.com/username"
                           value="{{$profile->tiktok}}">
                    <select name="tiktok-follow" id="tiktok-follow"
                            class="text-gray-700 rounded-full w-full my-2 border-none text-sm md:text-md py-1 px-2"
                            style="box-shadow: 0 0 8px 0 #999">
                      <option>How many followers?</option>
                      <option value="11" @if($profile->tiktok_follows == 11) selected @endif>
                        1k-10k
                      </option>
                      <option value="60" @if($profile->tiktok_follows == 60) selected @endif>
                        10k-50k
                      </option>
                      <option value="600" @if($profile->tiktok_follows == 600) selected @endif>
                        100k-500k
                      </option>
                    </select>
                  </div>
                </div>
                <div class="w-11/12 flex align-items-center mb-3 mx-auto">
                  <input type="checkbox" name="website_check[]" id="website_check" value="checked" onclick="checkSocialLink($(this))" @if($profile->website_check == 1) checked @endif>
                  <label for="website_check"></label>
                  <button type="button"
                          class="block py-1 mx-auto rounded-xl text-sm bg-white w-10/12"
                          style="box-shadow: 0 0 8px 0 #999" onclick="$('div#website_block').toggle();">
                    <i class="fas fa-globe"></i>&nbsp;&nbsp;&nbsp;Add Website
                  </button>
                </div>
                <div class="w-11/12 mx-auto grid grid-cols-12 mb-2 hidden" id="website_block">
                  <div class="col-span-12 md:col-span-11">
                    <input type="text" name="website-link" id="website-link"
                           class="text-gray-700 rounded w-full my-2 border-none text-sm md:text-md py-1 px-2"
                           style="box-shadow: 0 0 8px 0 #999"
                           placeholder="{{($accountInfo->accountType == 'influencer') ? __('Your portfolio website') : __('Your company website') }}"
                           value=@if($profile->website !== 'none') {{ $profile->website }} @endif >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full">
            <button type="submit"
                    class="relative text-white font-semibold block mx-auto px-20 py-2 rounded -top-16"
                    style="background: #0ac2c8">Update
            </button>
          </div>
          <div id="error"></div>
        </div>
      </form>
    </div>
    {{-- upload modal --}}
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
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
  </main>
  <script>
    let cropper, filesValue, width, height, position, $modal = $("#modal"),
      image = document.getElementById("image"), api_token = $("meta[name=api-token]").attr("content");

    function checkSocialLink(elem) {
      let count = 0;
      for(let i = 0 ; i < 4 ; i ++) {
        if($("#social-media-links input:checkbox").eq(i).is(':checked'))
          count ++;
      }
      console.log(count);
      if(count > 3) {
        $(elem).prop('checked', false);
      }
    }

    function categoryToggle() {
      const e = $("div#categories_box");
      e.toggle(), "none" == e.css("display") ? $("a#categoryToggle i").removeClass("fa-chevron-up").addClass("fa-chevron-down") : $("a#categoryToggle i").removeClass("fa-chevron-down").addClass("fa-chevron-up")
    }

    function checkboxClick(e) {
      const a = $("input#categories");
      let t = $(a).val();
      const o = $("div#categories_box input[type='checkbox']");
      t = "";
      let i = 0;
      for (let a = 0; a < o.length; a++) {
        const n = o[a];
        $(n).is(":checked") && i < 2 ? (t = t + $(n).parent().text().trim() + ' ', i++) : $(n).is(":checked") && i >= 2 && $(e).trigger("click")
      }
      a.val(t)
    }

    function displayLength() {
      const e = $("textarea#introduction").val();
      $("span#intro_length").text(e.length)
    }

    function editImg(e) {
      position = e;
      const a = document.getElementById("hidden-input");
      $("input#position").val(position), a.click(), a.onchange = (e => {
        var a, t, o = e.target.files, i = function (e) {
          image.src = e, $modal.modal("show")
        };
        o && o.length > 0 && (t = o[0], URL ? i(URL.createObjectURL(t)) : FileReader && ((a = new FileReader).onload = function (e) {
          i(a.result)
        }, a.readAsDataURL(t)))
      })
    }

    function removeImage(e, a) {
      var t = e.prev().attr("alt"), o = "{{ url('/') }}/api/deleteImage?api_token=";
      o += api_token, $.ajax({
        url: o, type: "POST", data: {filename: t, position: a}, success: function (a) {
          "success" == a.data && e.parent().remove()
        }, error: function (e, a, t) {
        }
      })
    }

    $modal.on("shown.bs.modal", function () {
      var e;
      switch (position) {
        case"top":
          e = .8, width = 1056, height = 1320;
          break;
        case"round":
          e = 1, width = 400, height = 400;
          break;
        case"portfolio":
          e = .8, width = 528, height = 660;
          break;
        case"partnership":
          e = 2, width = 528, height = 264;
      }
      cropper = new Cropper(image, {aspectRatio: e, viewMode: 3, preview: ".preview"})
    }).on("hidden.bs.modal", function () {
      cropper.destroy(), cropper = null
    }), $("#crop").click(function () {
      canvas = cropper.getCroppedCanvas({
        width: width,
        height: height
      }), $("#uploadModal").show(), canvas.toBlob(function (e) {
        url = URL.createObjectURL(e);
        var a = new FileReader;
        a.readAsDataURL(e), a.onloadend = function () {
          var e = a.result;
          switch (position) {
            case"top":
              $("img#top-image").attr("src", e);
              var t = "{{ url('/') }}/api/saveImage?api_token=";
              t += api_token, (r = new FormData).append("image", e), r.append("position", "top"), $.ajax({
                url: t,
                data: r,
                processData: !1,
                contentType: !1,
                type: "POST",
                success: function (e) {
                  $("#uploadModal").hide()
                },
                error: function (e, a, t) {
                }
              });
              break;
            case"round":
              $("img#round-image").attr("src", e);
              t = "{{ url('/') }}/api/saveImage?api_token=";
              t += api_token, (r = new FormData).append("image", e), r.append("position", "round"), $.ajax({
                url: t,
                data: r,
                processData: !1,
                contentType: !1,
                type: "POST",
                success: function (e) {
                  $("#uploadModal").hide()
                },
                error: function (e, a, t) {
                }
              });
              break;
            case"portfolio":
              var o = $('<div id="gallery-item" class="float-left mr-3 my-2 relative"></div>'),
                i = $('<img src="' + e + '" alt="" class="rounded-sm" style="width: 65px; box-shadow:0 0 5px #333">'),
                n = $('<a class="block absolute w-5 h-5 text-center rounded-full bg-red-600 text-white text-xs -top-2 -right-2" onclick="removeImage($(this), \'portfolio\')"><span class="leading-5">X</span></a>');
              o.append(i), o.append(n), $("#portfolio-gallery").append(o);
              t = "{{ url('/') }}/api/saveImage?api_token=";
              t += api_token, (r = new FormData).append("image", e), r.append("position", "portfolio"), $.ajax({
                url: t,
                data: r,
                processData: !1,
                contentType: !1,
                type: "POST",
                success: function (e) {
                  $("#uploadModal").hide();
                  var a,
                    t = "{{ url('/storage/profile-image') }}/" + (a = (a = e.file.split("/"))[a.length - 1]) + ".jpg";
                  $("#portfolio-gallery div:last-child img").attr("src", t), $("#portfolio-gallery div:last-child img").attr("alt", a)
                },
                error: function (e, a, t) {
                }
              });
              break;
            case"partnership":
              o = $('<div id="gallery-item" class="float-left mr-3 my-2 relative"></div>'), i = $('<img src="' + e + '" alt="" class="rounded-sm" style="width: 65px; box-shadow:0 0 5px #333">'), n = $('<a class="block absolute w-5 h-5 text-center rounded-full bg-red-600 text-white text-xs -top-2 -right-2" onclick="removeImage($(this), \'partnership\')"><span class="leading-5">X</span></a>');
              o.append(i), o.append(n), $("#partnership-gallery").append(o);
              var r;
              t = "{{ url('/') }}/api/saveImage?api_token=";
              t += api_token, (r = new FormData).append("image", e), r.append("position", "partnership"), $.ajax({
                url: t,
                data: r,
                processData: !1,
                contentType: !1,
                type: "POST",
                success: function (e) {
                  $("#uploadModal").hide();
                  var a,
                    t = "{{ url('/storage/partnership-image') }}/" + (a = (a = e.file.split("/"))[a.length - 1]) + ".jpg";
                  $("#partnership-gallery div:last-child img").attr("src", t), $("#partnership-gallery div:last-child img").attr("alt", a)
                },
                error: function (e, a, t) {
                }
              })
          }
          $modal.modal("hide")
        }
      })
    });
  </script>
@endsection
