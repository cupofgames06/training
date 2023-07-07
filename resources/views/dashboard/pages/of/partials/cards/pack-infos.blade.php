<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
        {{ __('of.packs.main.title') }}</div>
    <div class="card-body">
        <div class="row">
            <input type="hidden" name="pack[type]"  id="pack_type" value="{{ $pack_type }}"/>
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field label="{{ __('pack.reference') }}"
                                   :value="!empty($pack)?$pack->description->reference:''"
                                   name="description[reference]">
                </x-form.text-field>
            </div>
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field type="number" label="{{ __('pack.max_learners') }}"
                                   :value="!empty($pack)?$pack->description->max_learners:''"
                                   name="description[max_learners]" min="0">
                </x-form.text-field>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="pack_prerequisite">
                    {{ __('pack.pre_requisite_quiz') }}
                </label>
                <x-form-select
                    id="pack_pre_requisite_quiz"
                    name="description[pre_requisite_quiz]"
                    :options="trans('common.bool')"
                    :default="!empty($pack)?$pack->description->pre_requisite_quiz:null"
                    class="form-control" data-type="select2"/>
            </div>
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="pack_intra">
                    {{ __('pack.intra') }}
                </label>
                <x-form-select
                    id="description_intra"
                    name="description[intra]"
                    :options="trans('common.bool')"
                    :default="!empty($pack)?$pack->description->intra:null"
                    class="form-control" data-type="select2"/>
            </div>
        </div>

    </div>
</div>
