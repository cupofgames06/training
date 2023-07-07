<x-login-layout>
    <div class="row">
        <div class="col bg-white">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-md-8">

                        <p class="h3 text-decoration-none fw-bold mb-4" href="#">
                            @lang('auth.login.title')
                        </p>

                        <div class="d-grid ">
                            <a href="{{ route('google') }}" type="button" class="btn btn-google py-2 border-muted">
                                <img src="{{ asset('images/google-icon.svg') }}" alt="">
                                @lang('auth.google.btn')
                            </a>
                        </div>
                        <hr data-content="OU" class="hr-text my-4">

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email"
                                       class="form-label text-muted text-uppercase">@lang('auth.email.label')</label>


                                <input id="email" type="email"
                                       class="form-control border-muted py-2 bg-white @error('email') is-invalid @enderror "
                                       name="email" placeholder="@lang('auth.email.placeholder')"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password"
                                           class="form-label mb-0 text-muted text-uppercase">@lang('auth.password.label')</label>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-muted text-decoration-none fw-bold p-0"
                                           href="{{ route('password.request') }}">
                                            @lang('auth.password.forget')
                                        </a>
                                    @endif
                                </div>

                                <input id="password" type="password"
                                       class="form-control py-2 border-muted bg-white @error('password') is-invalid @enderror"
                                       placeholder="@lang('auth.password.placeholder')" name="password" required
                                       autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary py-2">
                                    @lang('auth.login.btn')
                                </button>
                            </div>
                            <hr class="hr-text">
                            <div class="text-muted text-center mb-4">
                                <p>@lang('auth.register.question')</p>
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('register') }}" class="btn btn-light-secondary py-2">
                                    @lang('auth.register.btn')
                                </a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class="col bg-white d-none d-lg-block px-0">
            <div class="d-flex justify-content-center align-items-center min-vh-100">
                <img src="{{ asset('images/'.get_domain().'/login.png') }}">
            </div>
        </div>
    </div>

</x-login-layout>
