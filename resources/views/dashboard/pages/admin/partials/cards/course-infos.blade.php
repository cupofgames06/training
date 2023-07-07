<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
        {{ __('of.courses.main.title') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col mb-3 pb-3">
                <label class="form-label w-100" for="course[category_id]">
                    {{ __('course.type') }}
                </label>
                <x-form-select
                    :default="!empty($course)?$course->type:null"
                    name="course[type]"
                    id="course_type"
                    :options="\App\Models\Course::getTypeList()"
                    class="form-control" data-type="select2"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field label="{{ __('course.reference') }}"
                                   :value="!empty($course)?$course->description->reference:''"
                                   name="description[reference]">
                </x-form.text-field>
            </div>
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="course_code">
                    {{ __('course.code') }}
                </label>
                <x-form-select
                    id="course_code"
                    name="description[code]"
                    :options="custom('course-code')"
                    :default="!empty($course)?$course->description->code:null"
                    class="form-control" data-type="select2"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field type="number" label="{{ __('course.duration') }}"
                                   :value="!empty($course)?$course->duration:''"
                                   name="course[duration]" min="1">
                </x-form.text-field>
            </div>

            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field type="number" label="{{ __('course.max_learners') }}"
                                   :value="!empty($course)?$course->description->max_learners:''"
                                   name="description[max_learners]" min="0">
                </x-form.text-field>
            </div>
        </div>

        <x-form.tags-field group="course" multiple="true"
                           :selected="!empty($course)?$course->tags->pluck('id')->toArray():[]"></x-form.tags-field>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="course_prerequisite">
                    {{ __('course.pre_requisite_quiz') }}
                </label>
                <x-form-select
                    id="course_pre_requisite_quiz"
                    name="description[pre_requisite_quiz]"
                    :options="trans('common.bool')"
                    :default="!empty($course)?$course->description->pre_requisite_quiz:null"
                    class="form-control" data-type="select2"/>
            </div>
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="course_intra">
                    {{ __('course.intra') }}
                </label>
                <x-form-select
                    id="description_intra"
                    name="description[intra]"
                    :options="trans('common.bool')"
                    :default="!empty($course)?$course->description->intra:null"
                    class="form-control" data-type="select2"/>
            </div>
        </div>
    </div>
</div>
