<div id="file-upload-container-{!! $id !!}">

    <div class="file-upload d-flex justify-content-between mt-3"
         data-id="{!! $id !!}"
         data-upload-url="{!! $url !!}"

         @if( !empty($accepted_files))
             data-accepted-files="{!! implode('|',$accepted_files) !!}"
         @endif

         @if( !empty($file))
         data-filename="{!! $file->name !!}"
         data-filesize="{{ round($file->size/1e+6,2) }}"
         data-file-id="{!! $file->id !!}"
         @endif

         @if( !empty($module->id))
             data-delete-url="{{ route('of.quizzes.delete_image',[$module->id]) }}"
        @endif
    >
        <div class="d-flex justify-content-start align-items-center">
            <div class="me-2">
          <span class="fa-stack fa-1x">
            <i class="fas fa-circle fa-stack-2x text-primary opacity-25"></i>
            <i class="fas  fa-file-arrow-down text-primary fa-stack-1x"></i>
          </span>
            </div>
            <div class="text-dark fw-normal small file-upload-text">
                {!! $text !!}
            </div>
        </div>
        <div>
            <div class="form-group">
                <input id="{!! $id !!}" type="file" name="{!! !empty($name)?$name:$id !!}" class="d-none">
                <label class="btn input-file-upload"
                       for="{!! $id !!}">{{ __('Parcourir') }}</label>
            </div>

            <input id="delete[{!! $id !!}]" type="hidden" name="delete[{!! $id !!}]">
        </div>
    </div>

    <div class="file-progress d-none justify-content-between mt-3 p-3 border-2 border-muted rounded">

        <div class="d-flex justify-content-start align-items-center">
                  <span class="fa-stack fa-1x">
                    <i class="fas fa-circle fa-stack-2x text-primary opacity-25"></i>
                    <i class="fas fa-file-arrow-down text-primary fa-stack-1x"></i>
                  </span>
        </div>

        <div class="px-2" style="flex: 1 1 auto;">
            <div class="progress-name text-dark fw-bold text-break"></div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                     aria-valuemax="100"></div>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <div class="btn btn-outline-secondary cancel-upload rounded-circle"><i class="icon fas fa-xmark"></i></div>
        </div>

    </div>

    <div class="file-exists d-none justify-content-between mt-3 p-3 border-2 border-muted rounded">
        <div class="d-flex justify-content-start align-items-center">
                  <span class="fa-stack fa-1x">
                    <i class="fas fa-square-full fa-stack-2x text-primary opacity-25"></i>
                    <i class="fas fa-image text-primary fa-stack-1x"></i>
                  </span>
        </div>
        <div class="px-2" style="flex: 1 1 auto;">
            <div class="file-name text-dark fw-bold w-100 text-break"></div>
            <div class="file-size text-dark">18 MB</div>
        </div>
        <div class="d-flex justify-content-end align-items-center">
            <div class="btn btn-white rounded-circle delete-file"><i class="icon text-dark fas fa-trash-alt"></i></div>
        </div>
    </div>

</div>
