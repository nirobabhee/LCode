@forelse ($userReviews->take(10) as $review)
    <div class="review-block">
        <h6 class="my-2">@lang('Review of') <a href="{{ route('company.details', $review->company_id) }}"
                class="text--base">{{ __($review->company->name) }}</a></h6>
        <div class="customer-review">
            <div class="customer-review__thumb">
                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$company->image,imagePath()['profile']['user']['size']) }}"
                    alt="image">
            </div>
            <div class="customer-review__content">
                <div class="customer-review__header">
                    <div class="left">
                        <h6>{{ __(auth()->user()->fullname) }}</h6>
                        <span><i class="las la-map-marker-alt"></i>{{ __(auth()->user()->address->country) }}</span>
                    </div>
                    <div class="right">
                        <div class="total-ratings">
                            {{ showAmount(@$review->rating) }}
                        </div>
                        <div class="ratings d-flex align-items-center justify-content-end">
                            @php
                                echo rating($review->rating);
                            @endphp
                        </div>
                    </div>
                </div>
                <div class="customer-review__body">
                    <p>{{ __($review->review) }}</p>
                </div>
                <div class="customer-review__footer">
                    <div class="left">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="edit-review" type="button" data-bs-toggle="modal"
                                    data-bs-target="#reviewUpdateModal" data-resource="{{ $review }}"
                                    data-img="{{ getImage(imagePath()['company']['path'] . '/' . $review->company->image, imagePath()['company']['size']) }}"><i
                                        class="las la-edit"></i>
                                    @lang('Edit Review')</button>
                            </li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="delete-review" type="button" data-bs-toggle="modal"
                                    data-bs-target="#reviewDeleteModal" data-id="{{ $review->id }}"><i
                                        class="las la-trash-alt"></i>
                                    @lang('Delete')</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- customer-review end -->
    </div><!-- review-block end -->
@empty
    <div class="review-block">
        <div class="customer-review">
            <div class="center">
                <h5>@lang('No More Review')</h5>
            </div>
        </div>
    </div><!-- customer-review end -->
@endforelse
@if (count($userReviews) > 0 && count($userReviews) > 9)
    {{-- <div id="reviewArea"></div> --}}
    <div class="loadMore btn btn-sm btn--base float-right" data-last_id='{{ @$review->id }}'>
        @lang('See More..')
    </div>
@endif
