<div class="sidebar ms-3 rounded-4">
    <div class="d-flex flex-column justify-content-between align-items-center h-100">
        <ul>
            @foreach($navbars as $item)
                @if(isset($item->childrens) && $item->childrens->count() > 0)
                    <li>
                        <a href="{{ $item->route != ''?route($item->route):'#' }}"
                           data-bs-toggle="collapse"
                           data-bs-target="#childrens_{{ $item->childrens->first()->id }}"
                           aria-expanded="false"
                           aria-controls="childrens_{{ $item->childrens->first()->id }}"
                           class="btn @if(Route::currentRouteName() == $item->route) active @endif">
                            <span class="icon">{!! $item->icon !!}</span>
                            <span class="title"> <span>{{ $item->title }}</span>
                                <span class="toggle-children" id="childrens_icon_{{ $item->childrens->first()->id }}">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                    </li>
                    <div class="collapse" id="childrens_{{ $item->childrens->first()->id }}">
                        <ul style="list-style: none;">
                            @foreach($item->childrens as $child)
                                <li>
                                    <a href="{{ $child->route != ''?route($child->route):'#' }}"
                                       class="btn btn-aside-navbar"><span class="title">{{ $child->title }}</span></a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <script>
                        window.addEventListener("DOMContentLoaded", (event) => {
                            const myCollaspe = document.getElementById('childrens_{{ $item->childrens->first()->id }}')
                            const icon = document.getElementById('childrens_icon_{{ $item->childrens->first()->id }}');
                            myCollaspe.addEventListener('hidden.bs.collapse', event => {
                                $(icon).html('<i class="fas fa-chevron-down"></i>');
                            })
                            myCollaspe.addEventListener('shown.bs.collapse', event => {
                                $(icon).html('<i class="fas fa-chevron-up"></i>');
                            })
                        });
                    </script>

                @else
                    <li><a href="{{ $item->route != ''?route($item->route):'#' }}"
                           class="btn @if( Route::current()->getControllerClass() == $item->controller) active @endif"><span
                                class="icon">{!! $item->icon !!}</span> <span
                                class="title"> {{ $item->title }}</span></a></li>
                @endif
            @endforeach

            @if( count(Auth::user()->getAccounts()) > 1)
                <li><a href="#"
                       data-bs-toggle="collapse"
                       data-bs-target="#childrens_accounts"
                       aria-expanded="false"
                       aria-controls="childrens_{{ Auth::user()->getAccounts()[0]->id }}"
                       class="btn btn-aside-navbar"><span
                            class="icon"><i class="fas fa-users"></i></span> <span
                            class="title"> <span>Mes autres comptes</span> <span
                                id="childrens_icon_{{ Auth::user()->getAccounts()[0]->id }}"><i
                                    class="fa-light fa-chevron-down"></i></span></span> </a></li>
                <div class="collapse" id="childrens_accounts">
                    <div>
                    <ul>
                        @foreach(Auth::user()->getAccounts() as $child)
                            <li>
                                <a href="{{ route('switch-account',['role'=>$child->route,'id'=>$child->id]) }}"
                                   class="btn"><span class="title">{{ $child->name }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                    </div>
                </div>
            @endif
        </ul>

        <ul>
            <li>
                <a href="{{ route(request()->segments()[2].'.help') }}"
                   class="btn @if(Route::current()->name == 'help') active @endif">
                    <span class="icon"><i class="far fa-circle-info fa-lg"></i></span>
                    <span class="title">Aide</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn w-100" type="submit">
                        <span class="icon"><i class="far fa-arrow-right-from-bracket fa-lg"></i> </span><span
                            class="title">Se déconnecter</span>
                    </button>
                </form>
            </li>
        </ul>

    </div>
</div>
<div id="backdrop" class="modal-backdrop fade show d-none"></div>
<script>

    let sidebar = document.querySelector('.sidebar');
    let backdrop = document.querySelector('#backdrop');
    let toggleButton = document.getElementById('toggleButton');

    document.addEventListener('DOMContentLoaded', function () {

        toggleButton.addEventListener("mouseup", function () {
            toggleSidebar();
        });

        sidebar.addEventListener("mouseover", openMenu);
        sidebar.addEventListener("mouseleave", closeMenu);

    });

    function openMenu() {
        sidebar.classList.add('sidebar-hover');
        sidebar.classList.add('show-titles');
        backdrop.classList.remove('d-none');
    }

    function closeMenu() {
        sidebar.classList.remove('sidebar-hover');
        sidebar.classList.remove('show-titles');
        backdrop.classList.add('d-none');
        sidebar.querySelectorAll('.collapse').forEach(function (item) {
            item.classList.remove('show');
        })

        sidebar.querySelectorAll('.fa-chevron-up').forEach(function (item) {
            item.classList.remove('fa-chevron-up');
            item.classList.add('fa-chevron-down');

        })

    }

    function toggleSidebar() {

        sidebar.removeEventListener("mouseover", openMenu);
        sidebar.removeEventListener("mouseleave", closeMenu);

        if (sidebar.classList.contains('show-titles')) {
            if(sidebar.classList.contains('hide-later')) {
                sidebar.classList.remove('d-flex');
            }

            toggleButton.innerHTML = '<i class="fa-solid fa-bars fa-lg"></i>';
            sidebar.addEventListener("mouseover", openMenu);
            sidebar.addEventListener("mouseleave", closeMenu);

            closeMenu();
        } else {
            if(!sidebar.classList.contains('d-none')) {
                sidebar.classList.add('hide-later');
            }

            sidebar.classList.add('d-flex');

            toggleButton.innerHTML = '<i class="fa-solid fa-chevron-left fa-lg"></i>';
            openMenu();

        }
    }
</script>
