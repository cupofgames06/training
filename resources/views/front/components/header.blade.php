<nav class="navbar navbar-expand-lg navbar-light header fixed-top">
    <div class="container-fluid mx-4">
        <a class="navbar-brand ms-0" href="#">
            <img src="{{ asset('images/'.get_domain().'/logo.png') }}"  alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold" aria-current="page" href="#">Nos formations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#">Contact</a>
                </li>
            </ul>
            <div class="d-flex flex-row align-items-center">
                <div class="dropdown me-4">
                    <button class="btn btn-white dropdown-toggle fw-semibold" type="button" id="dropdownHeaderMenu"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Str::of(app()->getLocale())->upper() }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-start w-25" aria-labelledby="dropdownHeaderMenu">
                        @foreach(config('app.supported_locales') as $locale)
                            <li><a class="dropdown-item {{ app()->getLocale() == $locale?'text-primary':'text-dark' }}"
                                   href="#">{{ Str::of($locale)->upper() }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('login') }}" class="btn-link text-primary">
                    <i class="fa-solid fa-circle-user fa-2x"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
