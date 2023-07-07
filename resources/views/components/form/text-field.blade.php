<label for="{{ !empty($id)?$id:$name }}" class="form-label">{!! !empty($label)?$label:''!!}</label>
<x-form-input id="{{ !empty($id)?$id:$name }}" name="{{ !empty($name)?$name:'' }}"
              value="{{ $value }}"
              placeholder="{{ $placeholder }}"
              {{ $attributes }}
              class="form-control"></x-form-input>


