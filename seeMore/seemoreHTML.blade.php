@extends($activeTemplate.'layouts.auth')
@section('content')
    <div class="col-xl-8 col-lg-8 mt-5" id="showReview">
        @include($activeTemplate.'partials.dashboard_review')
    </div><!-- review-block end -->


    <!-- review update modal -->
    <div class="modal fade" id="reviewUpdateModal" tabindex="-1" aria-labelledby="reviewUpdateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewUpdateModalLabel">@lang('Update Review')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update.review') }}" method="POST">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <div class="t-company-thumb">
                                        <img src="#" alt="image" class="view-image">
                                    </div>
                                    <div class="t-company-content">
                                        <h6 class="view-company"></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
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
                        </div>
                        <input type="hidden" class="edit-id" value="" name="id">
                        <textarea name="review" class="form--control edit-review"
                            placeholder="Write your review"></textarea>
                        <div class="text-end">
                            <button type="submit" class="btn btn--success" data-bs-dismiss="modal">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- review delete modal -->
    <div class="modal fade" id="reviewDeleteModal" tabindex="-1" aria-labelledby="reviewDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewDeleteModalLabel">@lang('Are You Delete Review ?')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('user.delete.review') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="" class="delete-id">
                        <button type="submit" class="btn btn-sm btn--danger">@lang('Yes')</button>
                        <button type="button" class="btn btn-sm btn--secondary" data-bs-dismiss="modal">@lang('No')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.edit-review').on('click', function() {
                var result = $(this).data('resource');

                $('.edit-id').val(result.id);
                $('.edit-review').val(result.review);
                console.log(result.review);
                $('.edit-rating').val(result.rating);
                $('.view-company').text(result.company.name);
                $('.view-image').attr('src', $(this).data('img'));
                // console.log(result.rating);

            });
            $('.delete-review').on('click', function() {
                $('.delete-id').val($(this).data('id'));

            });

            // Check Radio-box
            $(".give-rating input:radio").attr("checked", false);

            $(".give-rating input").click(function(e) {
                $(this).parent().siblings().removeClass("checked");
                $(this)
                    .parent()
                    .addClass("checked");
            });






            //loadMore Function//
            $(document).on('click', '.loadMore', function() {
                // var id = $(this).data('last_id')
                // // console.log(last_id);
                $.ajax({
                    url: "{{ route('user.seemore.review') }}",
                    method: 'GET',
                    data: {
                        id: $(this).data('last_id'),
                    },
                    success: function(response) {
                        $('#showReview').html(response)

                    },
                });
            });

            ////End Loadmore


        });
    </script>
@endpush



//controller//
public function seemoreReview()
{
    $id = $_GET['id'];
    $userReviews = Review::where('user_id', auth()->id())->where('id', '>', $id)->limit(10)->with('company')->get();
     return view($this->activeTemplate . 'partials.dashboard_review', compact('userReviews'));
}


//web//
Route::get('get/review', 'UserController@seemoreReview')->name('seemore.review');
