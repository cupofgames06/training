<div class="row">
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
                {{ __('of.promotions.main.title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <x-form.translated-textfield label="{{ __('of.promotions.name') }}"
                                                     name="promotion[name]"
                                                     :id="!empty($promotion)?'promotion_name_'.$promotion->id:'promotion_name'"
                                                     :values="!empty($promotion)?$promotion->getTranslations('name'):[]">
                        </x-form.translated-textfield>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field type="number" label="{{ __('of.promotions.amount') }}"
                                           :value="!empty($promotion)?$promotion->amount:''"
                                           name="promotion[amount]" min="0">
                        </x-form.text-field>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label class="form-label w-100" for="promotion_percent">
                            {{ __('of.promotions.percent') }}
                        </label>
                        <x-form-select
                            id="promotion_percent"
                            name="promotion[percent]"
                            :options="trans('common.bool')"
                            :default="!empty($promotion)?$promotion->percent:null"
                            class="form-control" data-type="select2"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label for="date_start" class="form-label">{{ __('of.promotions.date_start') }}</label>
                        <x-form-input id="date_start" name="promotion[date_start]"
                                      :value="!empty($promotion->date_start)?$promotion->date_start->format('d/m/Y'):''"
                                      data-date-format="dd/mm/yyyy"
                                      data-type="datepicker"
                                      class="form-control"></x-form-input>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label for="date_end" class="form-label">{{ __('of.promotions.date_end') }}</label>
                        <x-form-input id="date_end" name="promotion[date_end]"
                                      :value="!empty($promotion->date_end)?$promotion->date_end->format('d/m/Y'):''"
                                      data-date-format="dd/mm/yyyy"
                                      data-type="datepicker"
                                      class="form-control"></x-form-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <label for="code" class="form-label">{{ __('of.promotions.code') }}</label>
                        <x-form-input id="code" name="promotion[code]"
                                      :value="!empty($promotion->code)?$promotion->code:''"
                                      class="form-control"></x-form-input>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
                {{ __('of.promotions.companies_title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <label for="companies" class="form-label">{{ __('of.promotions.companies') }}</label>
                        <x-form-select
                            id="companies"
                            name="companies[]"
                            :options="\App\Models\Company::getList([1])"
                            multiple="true"
                            :default="!empty($promotion)?$promotion->companies()->pluck('id')->ToArray():[]"
                            class="form-control" data-type="select2"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
