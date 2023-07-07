<div class="card mb-4 intra-training">
    <div class="card-header">
        @empty($name)
            <i class="icon far fa-network-wired text-primary"></i>
            {{ __('of.intra_trainings.title') }}
        @else
            {{ $name }}
        @endempty

        @if(!empty($intra_training))
            <div class="float-end">
                <a href="#"
                   data-type="delete"
                   data-method="delete"
                   data-url="{{ route('of.intra-trainings.delete',['intra'=>$intra_training]) }}"
                   class="delete fas fa-close text-decoration-none" id="{{ $intra_training->id }}">
                </a>
            </div>
        @endif
    </div>
    <div class="card-body">
        @empty($intra_training)
            <div class="text-muted mb-4">{!! __('of.intra_trainings.sub_title') !!}</div>
        @endempty
        <label class="form-label w-100" for="_intra">
            {{ __('of.intra_trainings.companies') }}
        </label>
        <div class="row">
            <div class="col mb-3 pb-3">
                <x-form-select
                    name="intra_training[companies][]"
                    :options="\App\Models\Company::getList([$item->of_id])"
                    multiple="true"
                    :default="!empty($intra_training) && !empty($intra_training['companies'])?$intra_training['companies']:null"
                    class="form-control" data-type="select2"/>
            </div>

            @foreach(App\Models\PriceLevel::get() as $pl)
                <div class="form-label">Prix {{ $pl->name }}</div>
                <x-form.price-fields
                    :price="!empty($intra_training) && !empty($intra_training->getPrice($pl->id))?$intra_training->getPrice($pl->id)->toArray():''"
                    id="{{ !empty($intra_training)?$intra_training->id.'-'.$pl->id.'-price':'intra-training-price-'.$pl->id.'-price' }}"
                    :priceLevelId="$pl->id"></x-form.price-fields>
            @endforeach

        </div>
    </div>
    <div class="card-footer">
        @if(empty($intra_training))
            <div class="float-end">
                <x-form-submit id="create_intra" ajax="1">{{ __('of.intra_trainings.btn') }}
                </x-form-submit>
            </div>
        @else
            <div class="float-end">
                <x-form-submit id="update_intra{{ $intra_training->id }}" ajax="1">{{ __('common.update') }}
                </x-form-submit>
            </div>
        @endif
    </div>

</div>
