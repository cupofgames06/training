<div class="card mb-4 support">
    <div class="card-header">
        @empty($name)
            <i class="icon far fa-file-circle-info text-primary"></i>
            {{ __('of.supports.title') }}
        @else
            {{ $name }}
        @endempty

        @if(!empty($support))
            <div class="float-end">

                <a href="#"
                   data-type="delete"
                   data-method="delete"
                   data-url="{{ route('of.supports.delete',['support'=>$support->id]) }}"
                   class="delete fas fa-close text-decoration-none" id="{{ $support->id }}">
                </a>
            </div>
        @endif
    </div>
    <div class="card-body">
        @empty($support)
            <div class="text-muted mb-4">{!! __('of.supports.sub_title') !!}</div>
        @endempty

        <div class="row">
            <div class="col mb-3 pb-3">
                <div class="form-group">
                    <x-form-label class="form-label"
                                  label="Document"></x-form-label>
                    @component('components.form.file-upload')
                        @slot('id',!empty($support)?'support_document_'.$support->id:'support_document')
                        @slot('name',!empty($support)?'support_document_'.$support->id:'support_document')
                        @slot('url',  route('of.supports.upload_document',['id'=>!empty($support)?$support->id:null]) )
                        @slot('text',trans('of.supports.upload_document.text'))
                        @slot('accepted_files',['png','jpg','jpeg','pdf','doc','xsl','docx','xslx'])
                        @slot('file', !empty($support)?$support->getFirstMedia('documents'):null )
                    @endcomponent
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3 pb-3">
                <x-form.translated-textfield label="{{ __('of.supports.name') }}"
                                            name="support[name]"
                                            :id="!empty($support)?'support_name_'.$support->id:'support_name'"
                                            :values="!empty($support)?$support->getTranslations('name'):[]">
                </x-form.translated-textfield>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @if(empty($support))
            <div class="float-end">
                <x-form-submit id="create_intra" ajax="1">{{ __('of.supports.btn') }}
                </x-form-submit>
            </div>
        @else
            <div class="float-end">
                <x-form-submit id="update_support{{ $support->id }}" ajax="1">{{ __('common.update') }}
                </x-form-submit>
            </div>
        @endif
    </div>
</div>
