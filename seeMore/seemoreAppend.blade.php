@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('breadcum.content', true);
@endphp
@section('content')
    <section class="section--bg pb-100">
        <div class="company-details-bg bg_img d-lg-block d-none"
            style="background-image: url('{{ getImage('assets/images/frontend/breadcum/' . @$content->data_values->image, '1920x650') }}');">
        </div>

        <div class="company-details-header">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-8 ps-xxl-5">
                        <div class="row gy-4">
                            <div class="col-md-8 text-md-start text-center">
                                <div class="company-profile">
                                    <h3 class="company-profile__name">{{ $company->name }}</h3>
                                    <span><i class="las la-map-marker-alt"></i>{{ $company->address }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="company-website section--bg2 text-center has--link">
                                    <a href="{{ $company->url }}" class="item--link"></a>
                                    <h6 class="fs--16px text-white"><i
                                            class="las la-external-link-alt"></i>{{ $company->url }}</h6>
                                    <span class="fs--12px text-white">@lang('Visit this site')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="company-sidebar">
                        <div class="row gy-5">
                            <div class="company-sidebar__widget col-lg-12 col-md-5">
                                <div class="company-overview">
                                    <div class="company-overview__thumb">
                                        <img src="{{ getImage(imagePath()['company']['path'] . '/' . $company->image, imagePath()['company']['size']) }}"
                                            alt="image">
                                    </div>
                                </div>
                            </div><!-- company-sidebar__widget end -->

                            <div class="company-sidebar__widget col-lg-12 col-md-7">
                                <div class="rating-area d-flex flex-wrap align-items-center justify-content-between mb-4">
                                    <div class="rating">{{ showAmount(@$company->avgRating) }}</div>
                                    <div class="content">
                                        <div class="ratings d-flex align-items-center justify-content-end fs--18px">
                                            @php
                                                echo AvgRating($company->id);
                                            @endphp
                                        </div>
                                        <span class="mt-1 text-muted fs--14px">@lang('Based on')
                                            {{ @$company->reviews_count }} @lang('Reviews')</span>
                                    </div>
                                </div>


                                <div class="single-review">
                                    <p class="star"><i class="las la-star text--base"></i> 5</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $company->reviews_count? ($company->reviews->where('rating', 5)->count() / $company->reviews_count) * 100: '0' }}%"
                                            aria-valuenow="{{ $company->reviews_count? ($company->reviews->where('rating', 5)->count() / $company->reviews_count) * 100: '0' }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span
                                        class="percentage">{{ showAmount($company->reviews_count ? ($company->reviews->where('rating', 5)->count() / $company->reviews_count) * 100 : '0') }}%</span>
                                </div><!-- single-review end -->
                                <div class="single-review">
                                    <p class="star"><i class="las la-star text--base"></i> 4</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $company->reviews_count? ($company->reviews->where('rating', 4)->count() / $company->reviews_count) * 100: '0' }}%"
                                            aria-valuenow="{{ $company->reviews_count? ($company->reviews->where('rating', 4)->count() / $company->reviews_count) * 100: '0' }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span
                                        class="percentage">{{ showAmount($company->reviews_count ? ($company->reviews->where('rating', 4)->count() / $company->reviews_count) * 100 : '0') }}%</span>
                                </div><!-- single-review end -->
                                <div class="single-review">
                                    <p class="star"><i class="las la-star text--base"></i> 3</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $company->reviews_count? ($company->reviews->where('rating', 3)->count() / $company->reviews_count) * 100: '0' }}%"
                                            aria-valuenow="{{ $company->reviews_count? ($company->reviews->where('rating', 3)->count() / $company->reviews_count) * 100: '0' }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span
                                        class="percentage">{{ showAmount($company->reviews_count ? ($company->reviews->where('rating', 3)->count() / $company->reviews_count) * 100 : '0') }}%</span>
                                </div><!-- single-review end -->
                                <div class="single-review">
                                    <p class="star"><i class="las la-star text--base"></i> 2</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $company->reviews_count? ($company->reviews->where('rating', 2)->count() / $company->reviews_count) * 100: '0' }}%"
                                            aria-valuenow="{{ $company->reviews_count? ($company->reviews->where('rating', 2)->count() / $company->reviews_count) * 100: '0' }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span
                                        class="percentage">{{ showAmount($company->reviews_count ? ($company->reviews->where('rating', 2)->count() / $company->reviews_count) * 100 : '0') }}%</span>
                                </div><!-- single-review end -->
                                <div class="single-review">
                                    <p class="star"><i class="las la-star text--base"></i> 1</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $company->reviews_count? ($company->reviews->where('rating', 1)->count() / $company->reviews_count) * 100: '0' }}%"
                                            aria-valuenow="{{ $company->reviews_count? ($company->reviews->where('rating', 1)->count() / $company->reviews_count) * 100: '0' }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span
                                        class="percentage">{{ showAmount($company->reviews_count ? ($company->reviews->where('rating', 1)->count() / $company->reviews_count) * 100 : '0') }}%</span>
                                </div><!-- single-review end -->
                            </div>

                            <div class="company-sidebar__widget col-lg-12">
                                <div class="single-company-info">
                                    <h5 class="single-company-info__title">@lang('About') {{ __($company->name) }}</h5>
                                    <p class="mt-2">
                                        {{ __(@$company->about) }}
                                    </p>
                                </div>
                                <div class="single-company-info">
                                    <h5 class="single-company-info__title">@lang('Contact Info')</h5>
                                    <ul class="single-company-info__list">
                                        <li>
                                            <div class="icon"><i class="las la-link"></i></div>
                                            <div class="content"><a
                                                    href="{{ @$company->url }}">{{ @$company->url }}</a></div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="las la-map-marker-alt"></i></div>
                                            <div class="content">
                                                <p>{{ __(@$company->address) }}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="las la-envelope"></i></div>
                                            <div class="content"><a
                                                    href="mailto:{{ @$company->email }}">{{ @$company->email }}</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            {{-- //Advertisement// --}}
                            <div class="company-sidebar__widget col-lg-12 d-lg-block d-none">
                                <a href="#0" class="d-block">
                                    <img src="{{ asset($activeTemplateTrue . 'images/ad/s-1.jpg') }}" alt="image">
                                </a>
                            </div>


                        </div><!-- row end -->
                    </div>
                </div>
                <div class="col-lg-8 ps-xxl-5 mt-5">
                    @if (auth()->check())
                        <div class="give-rating-area mb-5">
                            <form action="{{ route('user.review', $company->id) }}" method="post">
                                @csrf

                                <div class="give-rating-person">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image,imagePath()['profile']['user']['size']) }}"
                                            alt="image">
                                    </div>
                                    <div class="content">
                                        <h6>{{ auth()->user()->fullname }}</h6>
                                        <button type="button" class="open-rating-form">@lang('Write a review')</button>
                                    </div>
                                    <div class='give-rating'>
                                        <span>
                                            <input id='str5' name='rating' type='radio' value='5'>
                                            <label for='str5'>★</label>
                                        </span>
                                        <span>
                                            <input id='str4' name='rating' type='radio' value='4'>
                                            <label for='str4'>★</label>
                                        </span>
                                        <span>
                                            <input id='str3' name='rating' type='radio' value='3'>
                                            <label for='str3'>★</label>
                                        </span>
                                        <span>
                                            <input id='str2' name='rating' type='radio' value='2'>
                                            <label for='str2'>★</label>
                                        </span>
                                        <span>
                                            <input id='str1' name='rating' type='radio' value='1'>
                                            <label for='str1'>★</label>
                                        </span>
                                    </div>
                                </div>

                                <div class="give-rating-form mt-4">
                                    <textarea name="review" class="form--control"
                                        placeholder="@lang('Write review')">{{ old('review') }}</textarea>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn--base">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="give-rating-area mb-5">
                            <div class="give-rating-person">
                                <div class="content">
                                    <button class="open-rating-form">@lang('Write a review')</button>
                                </div>
                                <div class='give-rating'>
                                    <span>
                                        <input id='str5' name='rating' type='radio' value='5'>
                                        <label for='str5'>★</label>
                                    </span>
                                    <span>
                                        <input id='str4' name='rating' type='radio' value='4'>
                                        <label for='str4'>★</label>
                                    </span>
                                    <span>
                                        <input id='str3' name='rating' type='radio' value='3'>
                                        <label for='str3'>★</label>
                                    </span>
                                    <span>
                                        <input id='str2' name='rating' type='radio' value='2'>
                                        <label for='str2'>★</label>
                                    </span>
                                    <span>
                                        <input id='str1' name='rating' type='radio' value='1'>
                                        <label for='str1'>★</label>
                                    </span>
                                </div>
                            </div>

                            <form class="give-rating-form mt-4">
                                <div class="text-end">
                                    <button type="text" class="btn btn--base">
                                        <h5>@lang('Please') <a href="{{ route('user.login') }}"
                                                class="text--primary">@lang('login')</a>
                                            @lang(' to add your review!')</h5>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif


                    <div class="customer-review-wrapper bg-white">

                        @include($activeTemplate.'partials.company_review')

                    </div><!-- customer-review-wrapper end -->
                </div>
            </div><!-- row end -->
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            //loadMore Function//
            $(document).on('click', '.loadMore', function() {
                $.ajax({
                    url: "{{ route('get.user.review', $company->id) }}",
                    method: 'GET',
                    data: {
                        id: $(this).data('last_id'),
                    },
                    success: function(response) {
                        // console.log(response.success);

                        if (response.success) {
                            var reviews = response.data;

                            $.each(reviews, function(index, review) {

                                var path ='{{ asset(imagePath()['profile']['user']['path']) }}';
                                var userImage = path + '/' + review.user.image;

                                var html =
                                    `<div class="customer-review">
                                    <div class="customer-review__thumb">
                                        <img src="${userImage}"alt="image">
                                    </div>
                                    <div class="customer-review__content">
                                        <div class="customer-review__header">
                                            <div class="left">
                                                <h6><a href="#">${review.user.firstname}  ${review.user.lastname}</a></h6>
                                                <span><i class="las la-map-marker-alt"></i>${ review.user.address.country}</span>
                                            </div>
                                            <div class="right">
                                                <div class="total-ratings">${review.rating.toFixed(2)}</div>
                                                <div class="ratings d-flex align-items-center justify-content-end">
                                                   ${rating(review.rating)}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="customer-review__body">
                                            <p>${review.review}</p>
                                        </div>
                                    </div>
                                </div>`

                                $('#reviewArea').append(html);

                                if (index == reviews.length - 1) {
                                    $('#loadMore').data('last_id', review.id);
                                }
                                console.log(reviews.length > 2);
                                if (reviews.length < 2) {
                                    $('#loadMore').addClass('d-none');
                                }
                            });
                        } else {
                            console.log(400);
                        }
                    },
                });
            });

            // Check Radio-box
            $(".give-rating input:radio").attr("checked", false);

            $(".give-rating input").click(function(e) {
                $(this).parent().siblings().removeClass("checked");
                $(this)
                    .parent()
                    .addClass("checked");
            });
        });

        $('.open-rating-form, .give-rating').on('click', function() {
            $('.give-rating-form').slideDown();
        });
    </script>
@endpush



///Controller//

public function getReview($company_id)
    {
       <!--  $id = $_GET['id']; -->
        $reviews = Review::where('company_id', $company_id)->where('id', '>', $id)->limit(1)->with('company', 'user')->get();
        // return view($this->activeTemplate . 'partials.company_review', compact('userReviews'));
        return ['success' => true, 'data' => $reviews];
    }

    //web-route//
Route::get('get/review/{id}', 'SiteController@getReview')->name('get.user.review');
