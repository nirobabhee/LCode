//loadMore Function//
$(document).on('click', '.loadMore', function() {
    $.ajax({
        url: "{{ route('get.user.review', $company->id) }}",
        method: 'GET',
        data: {
            id: $(this).data('last_id'),
        },
        success: function(response) {

            if (response.success) {
                var reviews = response.data;

                $.each(reviews, function(index, review) {

                    var path = '{{ asset(imagePath()['profile']['user']['path']) }}';

                    var userImage = path + '/' + review.user.image ;

                    var html =
                        `<div class="customer-review">
                        <div class="customer-review__thumb">
                            <img src="${userImage}"alt="image">
                        </div>
                        <div class="customer-review__content">
                            <div class="customer-review__header">
                                <div class="left">
                                    <h6>${review.user.firstname}  ${review.user.lastname}</h6>
                                    <span><i class="las la-map-marker-alt"></i>${ review.user.address.country}</span>
                                </div>
                                <div class="right">
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

                    if (reviews.length < 10) {

                        $('#loadMore').addClass('d-none');
                    }
                });
            } else {
                console.log(400);
            }
        },
    });
});