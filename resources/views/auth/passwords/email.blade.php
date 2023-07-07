<x-login-layout>
    <div class="row">
        <div class="col bg-white">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-md-8">

                        <p class="h3 text-decoration-none fw-bold mb-4" href="#">
                            @lang('auth.password.reset')
                        </p>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email"
                                       class="form-label text-muted text-uppercase fw-semibold">@lang('auth.email.label')</label>
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
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary py-2">
                                    {{ __('Send Password Reset Link') }}
                                </button>
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
