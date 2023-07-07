<nav class="bg-white fixed-top d-flex align-items-center justify-content-between justify-content-md-start py-2"
     style="z-index: 2000">

    <button class="btn btn-toggle-menu" type="button" id="toggleButton" onclick="toggleSidebar()">
        <span id="drawer_icon"><i class="fa-solid fa-bars fa-lg"></i></span>
    </button>

    <div class="d-sm-none d-flex">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/'.get_domain().'/logo.png') }}" alt="">
        </a>
    </div>

    <div class="d-sm-none d-flex flex-row align-items-center me-3">
        <a href="{{ route('login') }}" class="btn btn-aside-navbar">
            <i class="fa-solid fa-circle-user fa-lg"></i>
        </a>
    </div>

    <div class="d-sm-flex d-none justify-content-sm-between flex-fill">
        <div>
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/'.get_domain().'/logo.png') }}" alt="">
            </a>
        </div>
        <div class="d-flex justify-content-sm-between align-items-baseline">
            <div class="me-3">{{ auth()->user()->account_name }}</div>
            <div class="d-flex flex-row align-items-center me-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width: 32px;height: 32px">
                    {{ auth()->user()->profile->badge_letter }}
                </div>
            </div>
        </div>
    </div>

</nav>
@include('components._aside-menu')

