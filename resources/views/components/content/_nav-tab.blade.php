{{-- dropdown responsive --}}
<div class="mb-4 d-block d-xl-none">
    <select id="select-menu" name="customer-menu" class="form-control" data-type="select2">
        @foreach($items as $item)
            <option
                value="{{ !empty($item->route)?$item->route:'#' }}"
                @if(!empty($item->selected)) selected @endif>{{  $item->title }}
            </option>
        @endforeach
    </select>
</div>

{{-- menu desktop  --}}
<ul class="nav nav-tabs mb-3 d-none d-xl-flex" id="pills-tab" role="tablist">
    @foreach($items as $item)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $loop->index == 0?'ms-0 ps-0':'' }}  {{ !empty($item->selected)?'active text-dark':'' }}"
               id="pills-{{ $item->id }}-tab"
               @if(!empty($item->route))
                   @if(!empty($item->selected))
                       href="#"
               @else
                   href="{{ $item->route }}"
               @endif
               @else
                   data-bs-toggle="pill" data-bs-target="#pills-{{ $item->id }}"
               type="button" role="tab" aria-controls="pills-{{ $item->id }}" aria-selected="true"
                @endif
            >
                {!!   $item->title !!}
                @isset($item->count)
                    <span class="badge bg-primary-100 rounded-4 text-primary ms-1"> {{ $item->count }} </span>
                @endisset
            </a>
        </li>
    @endforeach
</ul>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            $('#select-menu').on('change', function (e) {
                window.location.href = $(this).val();
            });
        });
    </script>
@endpush
