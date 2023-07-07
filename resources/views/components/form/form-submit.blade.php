<button {!! $attributes->merge([
        'class' => "btn btn-primary text-white fw-bold",
        'type' => 'submit',
        'id' => 'submit_button'
    ]) !!}>
    {!! trim($slot) ?: __('Submit') !!}
</button>
@if( !empty($attributes['ajax'] ))
    @push('scripts')
        <script type="module">

            document.addEventListener("DOMContentLoaded", function (event) {


                let id = '{{ $attributes['id'] }}';
                let button = $('#' + id);

                let formSubmitCall;


                let form;
                @if( !empty($attributes['form_id'] ))
                    form = $('#{{ $attributes['form_id'] }}');
                button.click(function () {
                    form.submit();
                });
                @else
                    form = button.parents('form');
                @endif

                let url = form.attr('action');
                let method = form.attr('method');

                form.submit(function (e) {


                    if (formSubmitCall) {
                        formSubmitCall.abort();
                    }

                    let tinyMceEditors = $('textarea[data-type=tinyMce]');
                    $.each(tinyMceEditors, function () {
                        let c = tinymce.get($(this).attr('id')).getContent();
                        $(this).val(c);
                    })
                    button.addClass('opacity-75');
                    button.attr('data-content', button.html());
                    button.html('@lang('common.please_wait')');

                    /*Swal.fire({
                        title: '@lang('common.please_wait')',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        html: '<div class="d-flex justify-content-center align-items-center h-100"> <div class="loader"> <div class="loader-inner ball-pulse"></div> </div> </div>'
                    });*/

                    e.preventDefault();

                    formSubmitCall = $.ajax({
                        type: method,
                        url: url,
                        data: form.serialize(),
                        dataType: 'json',
                        error: function (data) {

                            form.find('.is-invalid').removeClass('is-invalid');
                            form.find('.invalid-feedback').remove();
                            form.find('.tox-tinymce').removeClass('border-danger');

                            let scrollOffset = 0;

                            $.each(data.responseJSON.errors, function (fieldName, errorBag) {

                                let errorMessages = '';
                                $.each(errorBag, function (i, message) {
                                    errorMessages += '' + message + ' ';
                                });
                                let errorElement = '<div class="invalid-feedback"> ' + errorMessages + ' </div>';

                                let element = form.find('[name="' + convertString(fieldName) + '"]');
                                if (element.offset()) {
                                    if (!scrollOffset || element.parent().offset().top < scrollOffset - 30) {
                                        scrollOffset = element.parent().offset().top - 30;
                                    }
                                }
                                element.addClass('is-invalid');

                                if (element.attr('data-type') === 'tinyMce') {

                                    if ($(element).next().next().hasClass('invalid-feedback')) {
                                        $(element).next().next().remove();
                                    }

                                    $(errorElement).insertAfter(element.next());

                                    $(element).next('.tox-tinymce').addClass('border-danger');

                                    //Si translated textarea component
                                    if (element.parent().parent().hasClass('translated-textarea-container')) {
                                        element.parent().parent().children().addClass('d-none');
                                        element.parent().removeClass('d-none');
                                        let select = element.parent().parent().parent().find('select');
                                        select.val('{{ app()->getLocale() }}').trigger("change");
                                    }


                                } else if (element.attr('data-type') === 'select2') {

                                    if ($(element).next().next().hasClass('invalid-feedback')) {
                                        $(element).next().next().remove();
                                    }

                                    $(errorElement).insertAfter(element.next());

                                } else if (element.parent().parent().hasClass('translated-textfield-container')) {

                                    //Si translated textfield component
                                    if ($(element).next().next().hasClass('invalid-feedback')) {
                                        $(element).next().next().remove();
                                    }

                                    element.parent().parent().children().addClass('d-none');
                                    element.parent().removeClass('d-none');
                                    let select = element.parent().parent().parent().find('select');
                                    select.val('{{ app()->getLocale() }}').trigger("change");

                                    // console.log(element.next());
                                    $(errorElement).insertAfter(element);

                                } else {

                                    if ($(element).next().hasClass('invalid-feedback')) {
                                        $(element).next().remove();
                                    }

                                    $(errorElement).insertAfter(element);

                                }
                            });

                            if (typeof data.responseJSON.alert !== 'undefined') {
                                Swal.fire({
                                    position: 'bottom-end',
                                    icon: 'error',
                                    title: data.responseJSON.alert,
                                    showConfirmButton: false,
                                    timer: 1800
                                });
                            } else {

                                $([document.documentElement, document.body]).animate({
                                    scrollTop: scrollOffset
                                }, 20);
                            }
                        },
                        success: function (data) {
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').each(function () {
                                $(this).removeClass('is-invalid');
                            });

                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1800,
                            }).then(function () {

                                if (typeof data.redirect !== 'undefined') {
                                    window.location.href = data.redirect;
                                } else if (typeof data.reload !== 'undefined') {
                                    window.location.reload();
                                }

                            });
                        }
                    });

                    formSubmitCall.fail(function (data) {
                        button.removeClass('opacity-75');
                        button.html(button.attr('data-content'));
                    });

                    formSubmitCall.done(function (data) {
                        button.removeClass('opacity-75');
                        button.html(button.attr('data-content'));
                    });

                });


                function convertString(str) {

                    const arr = str.split('.');
                    let newStr = arr[0];
                    for (let i = 1; i < arr.length; i++) {
                        newStr += `[${arr[i]}]`;
                    }

                    let is_valid = $('[name="' + newStr + '"]').length;
                    if (is_valid === 0) {
                        newStr += `[]`;
                    }
                    console.log(newStr);

                    return newStr;
                }

            });
        </script>
    @endpush
@endif
