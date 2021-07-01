@extends('layouts.admin')
@section('content')
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
            integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
          integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous"/>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <style>
        input {
            border: 1px solid lightgrey;
        }
    </style>
    <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
        <p class="italic text-lg text-white font-bold leading-8 pr-2"
           style="font-family: 'Josefin Sans', sans-serif;">{{ __('News Feed') }}</p>
    </div>
    <div class="md:h-screen md:overflow-auto">
        <div>
            <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
                <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('News Feed') }}</h2>
            </div>
            <div class="w-full px-3 py-3 md:float-left">
                <div class="max-w-4xl mx-auto">
                    <form action="{{ route('saveNews') }}" method="post">
                        {{ csrf_field() }}
                        <div class="w-full bg-gray-100 rounded-xl px-5 py-10">
                            <textarea name="back_img" id="back_img" cols="30" rows="10" hidden class="@error('back_img') is-invalid @enderror"></textarea>
                            @error('back_img')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <img src="" alt="back_img" style="display: none" class="w-1/4 mx-auto" id="back_img">
                            <p class="text-lg text-gray-300 font-bold text-center pb-3">Upload Cover Photo</p>
                            <button class="text-md rounded-full px-4 py-2 bg-gray-500 text-white block mx-auto"
                                    type="button" onclick="editImg('back_img')">Select photos
                            </button>
                        </div>
                        <div class="max-w-3xl mx-auto pt-10">
                            <div class="grid grid-cols-2 gap-x-4">
                                <div class="col-span-1">
                                    <div class="w-4/5 mx-auto rounded-full bg-white shadow-md px-1 py-1">
                                        <img src="{{ asset('img/avatar.png') }}" alt="avatar"
                                             class="w-full rounded-full" id="logo_img">
                                    </div>
                                    <textarea name="logo_img" id="logo_img" cols="30" rows="10" hidden class="@error('logo_img') is-invalid @enderror"></textarea>
                                    @error('logo_img')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <button class="mt-2 block mx-auto rounded-sm bg-gray-200 text-gray-500 px-4 py-2"
                                            type="button" onclick="editImg('logo_img')">Edit
                                        Picture
                                    </button>
                                </div>
                                <div class="col-span-1 relative">
                                    <div class="absolute w-full" style="transform: translateY(-50%); top: 50%;">
                                        <label for="full_name" class="font-bold w-full text-gray-500">Name</label>
                                        <input type="text" name="full_name" id="full_name"
                                               class="w-full px-2 py-3 text-gray-500 rounded-sm border-gray-200 @error('full_name') is-invalid @enderror"
                                               placeholder="Enter Full Name">
                                        @error('full_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full mt-5">
                            <label for="title" class="text-gray-500 font-bold">Project Title</label>
                            <input type="text" name="title" id="title" class="border-gray-200 w-full px-2 py-3 @error('title') is-invalid @enderror"
                                   placeholder="Enter Project Title">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="w-full mt-2">
                            <label for="description" class="text-gray-500 font-bold">Description</label>
                            <textarea type="text" name="description" id="description"
                                      class="bg-gray-100 border-none w-full px-2 py-3 @error('description') is-invalid @enderror"
                                      placeholder="It is a long established fact..."></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit"
                                class="block mx-auto md:mx-0 px-5 py-2 text-white text-sm md:text-lg mt-8 rounded-lg"
                                style="background: #0bc2c8">Publish
                        </button>
                    </form>
                </div>
                <div class="clearfix"></div>
                <input type="file" name="image" id="hidden-input" hidden>
                <input type="hidden" id="position">
            </div>
        </div>
    </div>
    <div class="fixed top-5 right-5 px-5 py-3 bg-red-600 text-white rounded-lg shadow-md hidden" id="alert">
        <h3></h3>
    </div>

    {{-- upload modal --}}
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg w-10/12 mx-auto" role="document">
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

    <script>
        const $modal = $('#modal');
        const image = document.getElementById('image');
        let cropper;
        let filesValue;
        let width, height;
        let position;
        const api_token = $("meta[name=api-token]").attr('content');

        function showAlert(text) {
            console.log(text);
            $("div#alert h3").text(text);
            $("div#alert").fadeIn(200).delay(3000).fadeOut(200);
        }

        function editImg(pos) {
            position = pos;
            const hidden = document.getElementById("hidden-input");
            $("input#position").val(position);

            hidden.click();
            hidden.onchange = (e) => {
                const files = e.target.files;
                const done = function (url) {
                    console.log(url);
                    image.src = url;
                    $modal.modal('show');
                };
                let reader;
                let file;
                let url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            };
        }

        $modal.on('shown.bs.modal', function () {
            let ratio;
            switch (position) {
                case 'back_img':
                    ratio = 1.0;
                    width = 660;
                    height = 660;
                    break;
                case 'logo_img':
                    ratio = 1;
                    width = 160;
                    height = 160;
                    break;
                default:
                    break;
            }
            cropper = new Cropper(image, {
                aspectRatio: ratio,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function () {
            let canvas = cropper.getCroppedCanvas({
                width: width,
                height: height,
            });

            $("#uploadModal").show();

            canvas.toBlob(function (blob) {
                let url = URL.createObjectURL(blob);
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    const base64data = reader.result;
                    switch (position) {
                        case 'back_img':
                            let elem = $("img#back_img");
                            elem.css('display', 'block');
                            elem.attr('src', base64data);
                            $("textarea#back_img").val(base64data);
                            break;

                        case 'logo_img':
                            $("img#logo_img").attr('src', base64data);
                            $("textarea#logo_img").val(base64data);
                            break;
                        default:
                            break;
                    }
                    $modal.modal('hide');
                }
            });
        });
    </script>

    @if(session('msg'))
        <script>showAlert("{{ session('msg') }}");</script>
    @endif

@endsection
