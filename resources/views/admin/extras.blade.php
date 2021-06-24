@extends('layouts.admin')
@section('content')
    <style>
        input {
            padding: 8px !important;
            border: 1px solid lightgrey !important;
        }

        input:focus, textarea:focus-visible {
            outline: none;
        }

        a:hover {
            color: gold !important;
        }
    </style>

    <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
        <p class="italic text-lg text-white font-bold leading-8 pr-2"
           style="font-family: 'Josefin Sans', sans-serif;">{{ __('News Feed') }}</p>
    </div>
    <div class="h-screen overflow-auto">
        <form action="{{ route('submitAdminReview') }}" method="get" id="submitForm">
        <div class="pb-20">
            <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
                <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('Extras') }}</h2>
            </div>
            <div class="w-full px-3 py-3 md:float-left md:w-3/4 lg:w-4/5 xl:w-5/6">
                <div class="w-full">
                    <a class="inline-block px-3 py-3 text-gray-400 mr-4 text-decoration-none cursor-pointer"
                       id="reviews">Reviews</a>
                    <a class="inline-block px-3 py-3 text-gray-400 mr-4 text-decoration-none cursor-pointer"
                       id="extras">Extras</a>
                </div>
                <div class="w-full pt-3">
                    <div class="relative w-full md:w-72">
                        <label for="username" class="mb-0 w-full">
                            <input type="text" name="username" id="username"
                                   class="rounded-full bg-gray-200 border-none px-3 py-2 w-full focus:outline-none @error('username') is-invalid @enderror"
                                   placeholder="Influencer name" value="{{ old('username') }}">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </label>
                        <buttton class="absolute right-2" style="top: 50%; transform: translateY(-50%);">
                            <li class="fas fa-search"></li>
                        </buttton>
                    </div>
                </div>
                <div class="w-full pt-8 md:w-9/12">
                    <label for="project_title" class="w-full">Project Title</label>
                    <input type="text" name="project_title" id="project_title" class="rounded-md w-full @error('project_title') is-invalid @enderror"
                           placeholder="Enter Project Title" value="{{ old('project_title') }}">
                    @error('project_title')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="w-full pt-8 md:w-10/12 lg:w-7/12" id="rating">
                    <div class="w-full grid grid-cols-2 gap-5">
                        <div class="col-span-1">
                            <p class="text-sm md:text-lg">Quality</p>
                        </div>
                        <div class="col-span-1">
                            <input type="hidden" id="quality" class="rating" value=0>
                            <ul id="quality" class="flex justify-content-between text-sm md:text-md lg:text-lg">
                                <li class="float-left"><a class="block w-6 md:w-12" id="1"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="2"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="3"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="4"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="5"><i
                                            class="fas fa-star"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-span-1">
                            <p class="text-sm md:text-lg">Communication</p>
                        </div>
                        <div class="col-span-1">
                            <input type="hidden" id="communication" class="rating" value=0>
                            <ul id="communication" class="flex justify-content-between text-sm md:text-md lg:text-lg">
                                <li class="float-left"><a class="block w-6 md:w-12" id="1"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="2"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="3"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="4"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="5"><i
                                            class="fas fa-star"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-span-1">
                            <p class="text-sm md:text-lg">Expertise</p>
                        </div>
                        <div class="col-span-1">
                            <input type="hidden" id="expertise" class="rating" value=0>
                            <ul id="expertise" class="flex justify-content-between text-sm md:text-md lg:text-lg">
                                <li class="float-left"><a class="block w-6 md:w-12" id="1"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="2"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="3"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="4"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="5"><i
                                            class="fas fa-star"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-span-1">
                            <p class="text-sm md:text-lg">Professionalism</p>
                        </div>
                        <div class="col-span-1">
                            <input type="hidden" id="professionalism" class="rating" value=0>
                            <ul id="professionalism" class="flex justify-content-between text-sm md:text-md lg:text-lg">
                                <li class="float-left"><a class="block w-6 md:w-12" id="1"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="2"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="3"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="4"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="5"><i
                                            class="fas fa-star"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-span-1">
                            <p class="text-sm md:text-lg">Would collaborate with again?</p>
                        </div>
                        <div class="col-span-1">
                            <input type="hidden" id="would_hire_again" class="rating" value=0>
                            <ul id="would_hire_again" class="flex justify-content-between text-sm md:text-md lg:text-lg">
                                <li class="float-left"><a class="block w-6 md:w-12" id="1"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="2"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="3"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="4"><i
                                            class="fas fa-star"></i></a></li>
                                <li class="float-left"><a class="block w-6 md:w-12" id="5"><i
                                            class="fas fa-star"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-9/12 pt-8">
                    <div class="w-full">
                        <label for="review" class="w-full">
                            <textarea name="review" id="review" cols="30" rows="5"
                                      placeholder="It is a long established fact..."
                                      class="bg-gray-200 rounded-xl border-none w-full px-3 py-3 @error('review') is-invalid @enderror" value="{{ old('review') }}"></textarea>
                            @error('review')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </label>
                        <label for="brand_name" class="w-full pt-8">Brand Name</label>
                        <input type="text" name="brand_name" id="brand_name" class="w-full rounded-lg @error('brand_name') is-invalid @enderror"
                               placeholder="Enter brand name" value="{{ old('brand_name') }}">
                        @error('brand_name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="date" class="w-full pt-8">Date</label>
                        <input type="date" name="date" id="date" class="w-full rounded-lg @error('date') is-invalid @enderror" placeholder="Enter date" value="{{ old('date') }}">
                        @error('date')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="hidden" name="totalRating" id="totalRating">
                        <button class="block mx-auto md:mx-0 px-5 py-2 text-white text-sm md:text-lg mt-8 rounded-lg"
                                style="background: #0bc2c8" type="submit" id="submit">Submit Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
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

        $(document).on('ready', function () {
            updateRating();
        })

        $("div#rating a").on('click', function () {
            let elem = $(this).parent().parent().children();
            console.log($(this).parent().parent().siblings('input'));
            $(this).parent().parent().siblings('input').val($(this).attr('id'));
            // console.log($(this).attr('id'));
            for (let i = 0; i < 5; i++) {
                if (i < $(this).attr('id'))
                    $(elem).eq(i).css('color', 'gold');
                else
                    $(elem).eq(i).css('color', 'inherit');
            }
            updateRating();
        });
        function updateRating() {
            let inputs = $("input.rating");
            let total = 0;
            for (let i = 0; i < 5; i++) {
                total += parseInt($(inputs).eq(i).val());
            }
            $('input#totalRating').val((total / 5.0).toFixed(1));
        }
    </script>
    @if(session('msg'))
        <script>showAlert("{{ session('msg') }}");</script>
    @endif
@endsection
