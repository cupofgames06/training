<div class="sticky-footer shadow-lg border-muted border-top px-4 py-2">
    @isset($buttons)
        <div class="d-flex justify-content-between">
            @else
                <div class="d-flex justify-content-end">
   @endisset

                    @isset($buttons)
                        <div class="d-flex align-items-center">
                            {{ $buttons }}
                        </div>
                    @endisset

                    <div class="d-flex justify-content-end align-items-center">
                        {{ $slot }}
                    </div>
                </div>
        </div>

