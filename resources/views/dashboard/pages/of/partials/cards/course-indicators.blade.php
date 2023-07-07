<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-chart-simple text-primary"></i>
        {{ __('of.courses.indicators.title') }}</div>
    <div class="card-body">
        <div class="text-muted mb-4">{{ __('of.courses.indicators.sub_title') }}</div>
        <div class="row">
            @foreach(\App\Models\Indicator::all() as $indicator)
                <div
                    class="{{ \App\Models\Indicator::all()->count() == 1?'col':'col-lg-6 col-md-12' }} mb-3 pb-3">
                    <x-form.text-field type="number"
                                       label="{{  $indicator->name.' ('.$indicator->unit.')' }}"
                                       name="indicators[{{ $indicator->id }}]" min="0"
                                       :value="(!empty($course) && $course->indicators->pluck('id')->contains($indicator->id))?$course->indicators->pluck('pivot.value','id')[$indicator->id]:''"
                                       max="{{ $indicator->objective }}">
                    </x-form.text-field>
                </div>
            @endforeach
        </div>
    </div>
</div>
