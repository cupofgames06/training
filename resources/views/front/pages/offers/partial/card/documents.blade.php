<div class="card mb-4 aside-summary">
    <div class="card-body">
        <div class="title">
            Documents
        </div>

        <hr>

        @isset($session)
            @foreach($session->supports as $support)
                <div class="d-flex flex-row justify-content-between mb-3">
                    <div class="d-flex flex-row align-items-center">
                        <i class="fa-solid fa-paperclip me-2"></i>
                        <span>{{ ucfirst($support->name) }} </span>
                    </div>
                    <a href="#" target="_blank">
                        <i class="fa-regular fa-cloud-arrow-down"></i>
                    </a>
                </div>
            @endforeach
        @endisset
        @isset($course)
            @foreach($course->supports as $support)
                <div class="d-flex flex-row justify-content-between mb-3">
                    <div class="d-flex flex-row align-items-center">
                        <i class="fa-solid fa-paperclip me-2"></i>
                        <span>{{ ucfirst($support->name) }} </span>
                    </div>
                    <a href="#" target="_blank">
                        <i class="fa-regular fa-cloud-arrow-down"></i>
                    </a>
                </div>
            @endforeach
        @endisset
    </div>
</div>
