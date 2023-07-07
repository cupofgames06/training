<div class="card mb-4 @if(!empty($packable) && $packable->type == 'elearning') draggable @endif packable"
     @if(!empty($packable)) data-id="{{ $packable->packables()->where('pack_id' ,$pack->id)->first()->id }}" @endempty">
<div class="card-header">
    @empty($packable)
        <i class="far fa-boxes-packing text-primary"></i>
        {{ __('of.packs.packables.title') }}
    @else
        <i class="far {{ $packable::class == 'App\Models\Session'?'fa-table-cells-large opacity-50':'fa-graduation-cap' }} text-primary"></i>
        {{ $name }}

        <div class="float-end">
            <a href="#"
               data-type="delete"
               data-method="delete"
               data-url="{{ route('of.packs.delete_packable',[$packable->packables()->first()->id]) }}"
               class="delete fas fa-close text-decoration-none" id="{{ $packable->id }}">
            </a>
        </div>
    @endif
</div>

@empty($packable)
    <x-form :action="route('of.packs.store_packable',[$pack->id])"
            name="create_packable_form_{{ $pack->id }}"
            id="create_packable_form_{{ $pack->id }}" v-on:submit="checkForm">
        @method('post')
        @csrf
        <div class="card-body">
            <div class="text-muted mb-4">{!! __('of.packs.packables.sub_title') !!}</div>
            <div class="row">
                <div class="col mb-3 pb-3">
                    <label class="form-label w-100" for="elearning">
                        {{ __('of.packs.packables.elearnings') }}
                    </label>
                    <x-form-select
                        id="elearning"
                        name="elearning[]"
                        :multiple="true"
                        :options="$elearningList"
                        class="form-control" data-type="select2"/>

                </div>
            </div>
            @if( $pack->type == 'blended')
                <div class="row">
                    <div class="col">
                        <label class="form-label w-100" for="course_intra">
                            {{ __('of.packs.packables.sessions') }}
                        </label>
                        <x-form-select
                            id="session"
                            name="session[]"
                            :multiple="true"
                            :options="$sessionList"
                            class="form-control" data-type="select2"/>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer float-end">
            <x-form-submit id="create_packable" ajax="1">{{ __('of.packs.packables.btn') }}
            </x-form-submit>
        </div>
    </x-form>
    @endempty
    </div>



