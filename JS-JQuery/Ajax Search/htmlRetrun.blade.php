@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('company_list_section.content', true);
@endphp
@section('content')
<section class="pt-50 pb-50 section--bg">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-3">
                <button class="action-sidebar-open d-flex justify-content-between align-items-center w-100">@lang('Filter')
                    <i class="las la-sliders-h"></i></button>
                <div class="action-sidebar">
                    <button class="action-sidebar-close"><i class="las la-times"></i></button>

                    <div class="action-widget pt-0">
                        <h4 class="action-widget__title">@lang('Categories')</h4>
                        <div class="action-widget__body">
                            <ul class="sidebar-category">
                                @forelse ($categories as $category)
                                <li class="sidebar-category__single">
                                    {{-- <a href="{{ route('category.company', $category->id) }}"> --}}
                                    <a href="#" class="category" data-id="{{ $category->id }}">
                                        <span class="caption">{{ __($category->name) }}</span>
                                        <span class="value">{{ $category->company_count }}</span>
                                    </a>
                                </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div><!-- action-widget end -->
                    <div class="action-widget">
                        <h4 class="action-widget__title">@lang('Search by Company or Tag')</h4>
                        <div class="action-widget__body">
                            <form class="search-form-inline" onsubmit='return false'>
                                <input type="text" name="search" autocomplete="off" value="" class="form--control form-control-sm" placeholder="Search here">
                                <button type="submit" class="search-form-inline__btn search"><i class="las la-search"></i></button>
                            </form>
                        </div>
                    </div><!-- action-widget end -->

                    <div class="action-widget">
                        <h4 class="action-widget__title">@lang('Rating Search')</h4>
                        <div class="action-widget__body">

                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" value="5" type="radio" name="ratingFilter" id="radio4-5">
                                    <label class="form-check-label" for="radio4-5">
                                        5 <span class="text--base">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" value="4" type="radio" name="ratingFilter" id="radio4-4">
                                    <label class="form-check-label" for="radio4-4">
                                        4 <span class="text--base">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>

                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" value="3" type="radio" name="ratingFilter" id="radio4-3">
                                    <label class="form-check-label" for="radio4-3">
                                        3 <span class="text--base">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" value="2" type="radio" name="ratingFilter" id="radio4-2">
                                    <label class="form-check-label" for="radio4-2">
                                        2
                                        <span class="text--base">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" type="radio" value="1" name="ratingFilter" id="radio4-1">
                                    <label class="form-check-label" for="radio4-1">
                                        1
                                        <span class="text--base"><i class="las la-star"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div><!-- action-widget end -->
                    <div class="action-widget">
                        <h4 class="action-widget__title">@lang('Review Period')</h4>
                        <div class="action-widget__body">
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" type="radio" name="reviewTime" value="1" id="radio-1">
                                    <label class="form-check-label" for="radio-1">
                                        @lang('Last month')
                                    </label>
                                </div>

                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" type="radio" name="reviewTime" value="2" id="radio-2">
                                    <label class="form-check-label" for="radio-2">
                                        @lang('Last 2 months')
                                    </label>
                                </div>

                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" type="radio" name="reviewTime" value="3" id="radio-3">
                                    <label class="form-check-label" for="radio-3">
                                        @lang('Last 3 months')
                                    </label>
                                </div>

                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" type="radio" name="reviewTime" value="6" id="radio-4">
                                    <label class="form-check-label" for="radio-4">
                                        @lang('Last 6 months')
                                    </label>
                                </div>

                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input" type="radio" name="reviewTime" value="12" id="radio-5">
                                    <label class="form-check-label" for="radio-5">
                                        @lang('Last year')
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div><!-- action-widget end -->
                    <div class="action-widget">
                        <h4 class="action-widget__title">@lang('Company Status')</h4>
                        <input type="hidden" name="startYear" value="">
                        <input type="hidden" name="endYear" value="">
                        <div class="action-widget__body">
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input status" type="radio" value="1" name="companyStatus" data-endyear="0" data-startyear="1" id="radio3-1">
                                    <label class="form-check-label" for="radio3-1">
                                        @lang('Below 1 year')
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input status" type="radio" value="2" name="companyStatus" data-endyear="1" data-startyear="3" id="radio3-2">
                                    <label class="form-check-label" for="radio3-2">
                                        @lang('1 - 3 years')
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input status" type="radio" value="3" name="companyStatus" data-endyear="3" data-startyear="6" id="radio3-3">
                                    <label class="form-check-label" for="radio3-3">
                                        @lang('3 - 6 years')
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input status" type="radio" value="4" name="companyStatus" data-endyear="6" data-startyear="10" id="radio3-4">
                                    <label class="form-check-label" for="radio3-4">
                                        @lang('6 - 10 years')
                                    </label>
                                </div>
                            </div>
                            <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <input class="form-check-input status" type="radio" value="10" name="companyStatus" data-endyear="10" data-startyear="10" id="radio3-5">
                                    <label class="form-check-label" for="radio3-5">
                                        @lang('Over 10 years')
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div><!-- action-widget end -->

                    <div class="action-widget bg--base mt-4 text-center rounded-3 p-4">
                        <h4 class="text-white">{{ __(@$content->data_values->title) }}</h4>
                        <a href="{{ $content->data_values->link }}" class="btn bg-white mt-4">{{ __(@$content->data_values->button_name) }}</a>
                    </div><!-- action-widget end -->

                    {{-- //Advertise-div --}}
                    <div class="action-widget">
                        <a href="#0" class="d-block mt-4">
                            <img src="{{ asset($activeTemplateTrue . 'images/ad/s-2.jpg') }}" alt="image">
                        </a>
                    </div>

                    <div class="action-widget">
                        <a href="#0" class="d-block">
                            <img src="{{ asset($activeTemplateTrue . 'images/ad/s-1.jpg') }}" alt="image">
                        </a>
                    </div>
                    {{-- //End Advertise-div --}}

                </div><!-- action-sidebar end -->
            </div>
            <div class="col-lg-9 ps-xxl-5">
                <div class="row gy-4" id="showCompanies">

                    {{-- Add Companies list blade here --}}
                    @include($activeTemplate.'company.companies')

                </div>
            </div>
            <nav class="mt-4">
                <ul class="pagination justify-content-end">
                    @if ($companies->hasPages())
                    {{ paginateLinks($companies) }}
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    </div>
</section>
<!-- review search section end -->
@endsection

@push('script')
<script>
    $(document).on('click', "input[type=radio]:checked, .category", function() {
                dadu(categroy);
            }

            $(document).on('click', ".search", function() {

                }

                function dadu(categroy = null, search = null) {

                }









                $(document).on('click', "input[type=radio]:checked, .category, .search", function() {

                    var category_id = $(this).data('id') ?? null;
                    var rating = $("input[name='ratingFilter']:checked").val() ?? null;
                    var review = $("input[name='reviewTime']:checked").val() ?? null;
                    var end = $(this).data('endyear') ?? null;
                    var start = $(this).data('startyear') ?? null;
                    var search = $('input[name=search]').val();

                    $.ajax({
                        url: "{{ route('search') }}",
                        method: 'GET',
                        data: {
                            'rating': rating,
                            'review': review,
                            'start': start,
                            'end': end,
                            'search': search,
                            'id': category_id,
                        },
                        success: function(response) {
                            $('#showCompanies').html(response)
                        },
                    });

                });






                // $('input[name=companyStatus]').on('change', function() {
                //     $('input[name=startYear]').val($(this).data('startyear'))
                //     $('input[name=endYear]').val($(this).data('endyear'))
                //     console.log($(this).data('endyear'));
                //     console.log($(this).data('startyear'));

                // })
                







        // $(document).on('click', "input[type=radio]:checked, .category, .search", function() {

        //     var id = $(this).data('id') ?? null;
        //     var rating = $("input[name='ratingFilter']:checked").val() ?? null;
        //     var review = $("input[name='reviewTime']:checked").val() ?? null;
        //     var end = $(this).data('endyear') ?? null;
        //     var start = $(this).data('startyear') ?? null;
        //     var search = $('input[name=search]').val();

        //     // $.ajax({
        //     //     url: "{{ route('search') }}",
        //     //     method: 'GET',
        //     //     data: {
        //     //         'rating': rating,
        //     //         'review': review,
        //     //         'start': start,
        //     //         'end': end,
        //     //         'search': search,
        //     //         'id': category_id,
        //     //     },
        //     //     success: function(response) {
        //     //         $('#showCompanies').html(response)
        //     //     },
        //     // });

        // });




                $('.action-widget__title').each(function() {
                    let widget = $(this).siblings('.action-widget__body');
                    $(this).on('click', function() {
                        widget.slideToggle();
                    });
                })

                $('ul.sidebar-category').each(function() {
                    var length = $(this).find('li').length;
                    if (length > 5) {
                        $('li', this).eq(4).nextAll().hide().addClass('toggleable');
                        $(this).append('<li class="more">See More...</li>');
                    }
                }); $('ul.sidebar-category').on('click', '.more', function() {
                    if ($(this).hasClass('less')) {
                        $(this).text('See More...').removeClass('less');
                    } else {
                        $(this).text('See Less...').addClass('less');
                    }
                    $(this).siblings('li.toggleable').slideToggle();
                });

                // value-Checked-after-search


                $("[type=radio][name='ratingFilter'][value={{ request()->ratingFilter ?? null }}]").prop("checked",
                    true);

                $("[type=radio][name='reviewTime'][value={{ request()->reviewTime ?? null }}]").prop("checked",
                    true);

                $("[type=radio][name='companyStatus'][value={{ request()->companyStatus ?? null }}]").prop("checked",
                    true);
</script>
@endpush


//controller//
public function search(Request $request)
{

// dd( 100);




if ($request) {

$query = Company::with('category')
->withAvg('reviews', 'rating')->withCount('reviews')
->where('status', 1);

//input
if ($request->search) {
$query = $query->where('name', 'like', "%$request->search%")
->orWhereJsonContains('tags', $request->search)
->orWhereHas('category', function ($q) use ($request) {
$q->where('name', $request->search);
});
}
//radio
if ($request->ratingFilter != "") {
$start = $request->ratingFilter - .1;
$end = ($request->ratingFilter == 5) ? 5 : $request->ratingFilter + .9;
$query = $query->whereBetween('avgRating', [$start, $end]);
}

if ($request->reviewTime != "") {
$startDate = Carbon::now()->subMonths($request->reviewTime);
$endDate = Carbon::now();
$query = $query->whereHas('reviews', function ($q) use ($startDate, $endDate) {
$q->whereBetween('created_at', [$startDate, $endDate]);
});
}
if ($request->companyStatus != "") {
if ($request->startYear < $request->endYear) {
    $endYear = Carbon::now()->subYear($request->startYear);
    $startYear = Carbon::now()->subYear($request->endYear);
    $query = $query->whereBetween('created_at', [$startYear, $endYear]);
    } else {
    $endYear = Carbon::now()->subYear($request->startYear);
    $query = $query->where('created_at', '<', $endYear); } } $companies=$query->latest()->paginate(getPaginate());
        $pageTitle = "Search Companies";
        } else {
        $pageTitle = 'Companies';
        $companies = Company::where('status', 1)->latest()->withAvg('reviews', 'rating')->withCount('reviews')->paginate(getPaginate());
        }

        $emptyMessage = "No $request->search, data found";
        $categories = Category::where('status', 1)->withCount('company')->whereHas('company', function ($q) {
        $q->where('status', 1);
        })->get();
        return view($this->activeTemplate . 'company.index', compact('pageTitle', 'categories', 'companies', 'emptyMessage'));
        }