
<?php
//1- helper
function avgRating($id)
{
    $review = Review::with('company')->where('company_id', $id)->get();
    if ($review->count()) {
        $averageRating = $review->sum('rating') / $review->count();
        $star = null;
        for ($i = 0; $i < 5; $i++) {
            if ($averageRating - $i >= 1) {
                $star .= '<i class="las la-star"></i>';
            } elseif ($averageRating - $i > 0) {
                $star .= '<i class="las la-star-half-alt"></i>';
            } else {
                $star .= '<i class="lar la-star"></i>';
            }
        }
        return $star;
    } else {
        $star = null;
        for ($i = 0; $i < 5; $i++) {
            $star .= '<i class="lar la-star"></i>';
        }
        return $star;
    }
}
//2 helper rating single id
function rating($rating)
{
    $star = '';
    for ($i = 0; $i < 5; $i++) {
        if (!($rating <= $i)) {
            $star .= '<i class="las la-star fa-lg"></i>';
        } else {
            $star .= '<i class="lar la-star fa-lg"></i>';
        }
    }
    return $star;
}


function avgRating($id)
{
    $company = Company::where('id', $id)->first();
    if ($company->avgRating) {
        $star = null;
        for ($i = 0; $i < 5; $i++) {
            if ($company->avgRating - $i >= 1) {
                $star .= '<i class="las la-star"></i>';
            } elseif ($company->avgRating - $i > 0) {
                $star .= '<i class="las la-star-half-alt"></i>';
            } else {
                $star .= '<i class="lar la-star"></i>';
            }
        }
        return $star;
    } else {
        $star = null;
        for ($i = 0; $i < 5; $i++) {
            $star .= '<i class="lar la-star"></i>';
        }
        return $star;
    }
}
// 3 -Blade
@if ($company->avgRating)
     <div class="company-overview__review mt-3">
     @for ($i = 1; $i <= 5; $i++)
     @if ($i == round($company->avgRating))
     <img src="{{ asset($activeTemplateTrue . 'images/icons/ratings/stars-' . $i . '.svg') }}"
                     alt="image">
        @endif
         @endfor
        <span class="caption">@lang('Reviewed by')
             {{ @$company->reviews_count }}</span>
     </div>
  @endif
