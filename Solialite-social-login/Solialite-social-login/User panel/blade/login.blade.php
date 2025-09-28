@php
    $login = getContent('login.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 pr-0 pl-0">
                    <div class="content-area bg_img"
                        data-background="{{ getImage('assets/images/frontend/login/' . @$login->data_values->image, '1024x720') }}">
                    </div>
                </div>

                <div class="col-lg-6 p-sm-0">
                    <div class="p-sm-5 p-4 custom--shadow">
                        <form class="verify-gcaptcha action-form" action="{{ route('user.login') }}" method="POST">
                            @csrf
                            <div class="login-area">
                                <h2 class="title">{{ __(@$login->data_values->heading) }}</h2>
                                <p>{{ __(@$login->data_values->subheading) }}</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Username')</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-user"></i></span>
                                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <x-captcha />

                            <div class="form-group d-flex justify-content-between flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        @checked(old('remember'))>
                                    <label class="form-check-label" for="remember"> @lang('Remember Me')</label>
                                </div>

                                <a href="{{ route('user.password.request') }}"> @lang('Forgot Password')?</a>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn cmn-btn w-100">@lang('Login')</button>
                            </div>
                        </form>
                        <p class="text-center">
                            @lang("Haven't an account")? <a href="{{ route('user.register') }}" >@lang('Register')</a>
                        </p>
                        @php
                            $credentials = $general->socialite_credentials;
                        @endphp
                        @if ($credentials->google->status == Status::ENABLE ||
                            $credentials->facebook->status == Status::ENABLE ||
                            $credentials->linkedin->status == Status::ENABLE)
                            <p class="text-center">
                                @lang('Or')
                                <br>
                                @lang('Login with')
                            </p>
                            <div class="d-flex flex-wrap gap-3">
                                @if ($credentials->facebook->status == Status::ENABLE)
                                    <a href="{{ route('user.social.login', 'facebook') }}"
                                        class="btn btn-outline-facebook btn-sm flex-grow-1">
                                        <span class="me-1"><i class="fab fa-facebook-f"></i></span> @lang('Facebook')
                                    </a>
                                @endif
                                @if ($credentials->google->status == Status::ENABLE)
                                    <a href="{{ route('user.social.login', 'google') }}"
                                        class="btn btn-outline-google btn-sm flex-grow-1">
                                        <span class="me-1"><i class="lab la-google-plus-g"></i></span> @lang('Google')
                                    </a>
                                @endif
                                @if ($credentials->linkedin->status == Status::ENABLE)
                                    <a href="{{ route('user.social.login', 'linkedin') }}"
                                        class="btn btn-outline-linkedin btn-sm flex-grow-1">
                                        <span class="me-1"><i class="lab la-linkedin-in"></i></span> @lang('Linkedin')
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .content-area {
            z-index: -1;
            height: 100%;
        }

        .btn-outline-linkedin {
            border-color: #0077B5;
            background-color: transparent;
            color: #0077B5;
        }

        .btn-outline-linkedin:hover {
            border-color: #0077B5;
            color: #fff !important;
            background-color: #0077B5;
        }

        .btn-outline-facebook {
            border-color: #395498;
            background-color: transparent;
            color: #395498;
        }

        .btn-outline-facebook:hover {
            border-color: #395498;
            color: #fff !important;
            background-color: #395498;
        }

        .btn-outline-google {
            border-color: #D64937;
            background-color: transparent;
            color: #D64937;
        }

        .btn-outline-google:hover {
            border-color: #D64937;
            color: #fff !important;
            background-color: #D64937;
        }

        .row>* {
            padding-right: calc(var(--bs-gutter-x) * .0);
        }
    </style>
@endpush
