<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
        {{ __('of.sessions.main.title') }}</div>
    <div class="card-body">

        <div class="row">
            <div class="col mb-3 pb-3">
                <label class="form-label w-100" for="session[course_id]">
                    {{ __('session.course') }}
                </label>
                <x-form-select
                    :default="!empty($session)?$session->course_id:null"
                    name="session[course_id]"
                    id="session_course_id"
                    :options="[''=>trans('common.select')]+\App\Models\Course::getList([],['virtual','physical'])"
                    class="form-control" data-type="select2"/>
            </div>
        </div>

        <div class="row classroom">
            <div class="col mb-3 pb-3">
                <label class="form-label w-100" for="session[classroom_id]">
                    {{ __('session.classroom') }}
                </label>
                <x-form-select
                    :default="!empty($session)?$session->classroom_id:null"
                    name="session[classroom_id]"
                    id="session_classroom_id"
                    :options="[''=>trans('common.select')]+\App\Models\Classroom::getList()"
                    class="form-control" data-type="select2"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field type="number" label="{{ __('session.cost') }}"
                                   :value="!empty($session)?$session->cost:''"
                                   name="session[cost]" min="0">
                </x-form.text-field>
            </div>
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field type="number" label="{{ __('course.max_learners') }}"
                                   :value="!empty($session)?$session->description->max_learners:''"
                                   name="description[max_learners]" min="0">
                </x-form.text-field>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="session_intra">
                    {{ __('session.intra') }}
                </label>
                <x-form-select
                    id="description_intra"
                    name="description[intra]"
                    :options="trans('common.bool')"
                    :default="!empty($session)?$session->description->intra:null"
                    class="form-control" data-type="select2"/>
            </div>
        </div>
    </div>
</div>
