<div class="row">
    <div class="col-md-12 col-lg-6 mb-4">
        @include('dashboard.pages.of.partials.cards.session-infos',['session'=>!empty($session)?$session:null])
        @include('dashboard.pages.of.partials.cards.internal-comment',['description'=>!empty($session)?$session->description:null])

        <div class="card mb-4">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-comment text-primary"></i>
                {{ __('of.sessions.psh_accessibility.title') }}</div>
            <div class="card-body">
                <div class="text-muted mb-4">{!!  __('of.sessions.psh_accessibility.sub_title')  !!}</div>
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <div class="form-group">
                            <div class="row">
                                <div class="col mb-3 pb-3">
                                    <x-form.translated-textarea label="{{ __('session.psh_accessibility') }}"
                                                                name="description[psh_accessibility]"
                                                                :values="!empty($session)?$session->description->getTranslations('psh_accessibility'):[]">
                                    </x-form.translated-textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        @include('dashboard.pages.of.partials.cards.promo-message',['description'=>!empty($session)?$session->description:null])
        @include('dashboard.pages.of.partials.cards.learner-message',['description'=>!empty($session)?$session->description:null])
    </div>
</div>

@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {

            let course_id = $("#session_course_id");
            let classroom = $(".classroom");
            course_id.on('change', toggleCourse);

            function toggleCourse() {

                if (!course_id.val()) {
                    classroom.addClass('d-none');
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: '{{ route('of.sessions.get_course',['course_id']) }}',
                    data: {course_id: course_id.val()},
                    dataType: 'json',
                    error: function (data) {

                    },
                    success: function (data) {
                        if (data.type === 'physical') {
                            classroom.removeClass('d-none');
                        } else {
                            classroom.addClass('d-none');
                        }
                    }
                });

            }

            toggleCourse();

        });
    </script>
@endpush
