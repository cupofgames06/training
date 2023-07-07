<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Hanken%20Grotesk" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js','resources/sass/'.get_domain().'.scss'])
    @yield('styles')

</head>
<body class="@yield('body-class') m-0">

<script>
    let finish = getComputedStyle(document.documentElement).getPropertyValue('--color-primary');
    let in_progress = getComputedStyle(document.documentElement).getPropertyValue('--color-primary-300');
    let next = getComputedStyle(document.documentElement).getPropertyValue('--color-primary-100');
    let font_family = getComputedStyle(document.documentElement).getPropertyValue('--font-family');
</script>

@stack('sticky-footer')

{{ $slot }}

@include('components.swa.swa-delete')

@yield('scripts')
<script type="module">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.route = function (route, params) {
        for (var key in params) {
            var value = params[key];
            route = route.replace(key, value);
        }
        return route;
    }

    //pour traduction entre différentes langues (textarea, textfield)
    window.toggleLanguageInput = function (event) {
        let select = $(event.target);
        let locale = select.val();
        let editors = select.parents('.translated-container').find('textarea,input');
        editors.each(function () {
            if ($(this).attr('id') === select.attr('id') + '_' + locale) {
                $(this).parent().removeClass('d-none');
            } else {
                $(this).parent().addClass('d-none');
            }
        });
    }

    window.initLanguageInput = function (element) {
        $(element).select2({
            dropdownCssClass: "select2-sm",
            selectionCssClass: "select2-sm",
            minimumResultsForSearch: -1
        }).on('select2:select', function (e) {
            window.toggleLanguageInput(e);
        });
    };

    //changement de langue d'édition d'un input inline (quiz page title...)
    window.toggleInlineFieldEditor = function (event) {

        let staticName = $(event.target);
        let container = staticName.parent().find('.translated-container');
        container.removeClass('d-none');
        staticName.addClass('d-none');

        container.find('input').unbind('keypress');
        container.find('input').bind('keypress', function (e) {
            if (e.which === 13) {
                if ($(e.target).val() !== '') {
                    staticName.html($(e.target).val());
                    container.addClass('d-none');
                    staticName.removeClass('d-none');
                    container.find('input').unbind('keypress');
                }
            }
        });

        //pose souci si select toggle lang
        /*container.find('input').unbind('blur');
        container.find('input').bind('blur', function (e) {
            console.log($(e.target).attr('id'));
            container.addClass('d-none');
            staticName.removeClass('d-none');
        });*/

    }

    window.initTinyMceInput = function (element) {

        tinymce.init({
            selector: element, // Replace this CSS selector to match the placeholder element for TinyMCE
            //plugins: 'code table lists',
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300&display=swap'); body { font-family: 'Hanken Grotesk', sans-serif; font-weight:500; } h1,h2,h3,h4,h5,h6 { font-family: 'Lato', sans-serif; }",
            plugins: 'lists',
            branding: false,
            menubar: false,
            toolbar: 'undo redo | formatselect| bold italic | bullist numlist'
            //toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

    }


    window.initTinyMceModuleInput = function (element) {

        let el = $(element);
        let content_css, body_class = null;
        let toolbar = 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | link | styles | code';

        if (typeof el.attr('data-css') != 'undefined') {
            content_css = el.attr('data-css');
        }

        if (typeof el.attr('data-toolbar') != 'undefined') {
            toolbar = el.attr('data-toolbar');
        }

        if (typeof el.attr('data-body-class') != 'undefined') {
            body_class = el.attr('data-body-class');
        }

        tinymce.init({
            selector: element, // Replace this CSS selector to match the placeholder element for TinyMCE
            content_css: content_css,
            body_class: body_class,
            plugins: 'lists link table code',
            content_css_cors: true,
            branding: false,
            menubar: false,
            toolbar: toolbar,
            style_formats: [
                {title: 'H1', block: 'h1'},
                {title: 'H2', block: 'h2'},
            ],
            setup: function (ed) {
                ed.on('blur', function (e) {
                    window.updateModuleContent(element);
                });
            },
        });
    }

    window.updateModuleContent = function (element) {

        let container = $(element).parents('.card');
        let module_id = container.attr('data-module');
        let form = container.find('form').get(0);

        let serializedData = $(form).serializeArray(); // Serialize the form data as an array
        serializedData.push({name: 'module_id', value: module_id});
        $(form).find('textarea').each(function () {
            tinymce.get($(this).attr('id')).save();
            serializedData.push({name: this.name, value: this.value});
        });

        $.ajax({
                type: 'post',
                url: '{{ route('of.quizzes.update_module') }}',
                data: serializedData,
                dataType: 'json',
                success: function (data) {

                }
            }
        );

    }

    window.initQuizVideo = function (element) {

        element.find('input[type=text]').each(function () {
            $(this).blur(function () {
                window.updateModuleContent(element);
            });
        });

    }

    window.initQuizAccordion = function (element) {

        element.find('[data-type=add-accordion-item]').each(function () {
            $(this).click(window.addAccordionItem);
        });

        element.find('input[type=text]').each(function () {
            $(this).blur(function () {
                window.updateModuleContent(element);
            });
        });

    }

    window.initQuizQcm = function (element) {

        element.find('[data-type=add-qcm-answer]').each(function () {
            $(this).click(window.addQcmAnswer);
        });

        element.find('input[type=text]').each(function () {
            $(this).blur(function () {
                window.updateModuleContent(element);
            });
        });

        element.find('input[type=checkbox]').each(function () {
            $(this).click(function () {
                window.updateModuleContent(element);
            });
        });
    }

    window.addAccordionItem = function (event) {

        let element = $(event.target);
        if (element.prop('nodeName').toLowerCase() !== 'button') {
            element = element.parent('button');
        }
        let url = element.attr('data-url');

        $.ajax({
            type: 'patch',
            url: url,
            dataType: 'json',
            error: function (data) {

            },
            success: function (data) {
                let tpl = $(data.template);
                tpl.insertBefore(element.parent());
                window.initInputs(tpl);

                tpl.find('input[type=text]').each(function () {
                    $(this).blur(function () {
                        window.updateModuleContent(tpl);
                    });
                });

                tpl.find('textarea').each(function () {
                    window.initTinyMceModuleInput('#' + $(this).attr('id'));
                });

                tpl.find('select').each(function () {
                    window.initLanguageInput('#' + $(this).attr('id'));
                });
            }
        });
    }

    window.addQcmAnswer = function (event) {

        let element = $(event.target);
        if (element.prop('nodeName').toLowerCase() !== 'button') {
            element = element.parent('button');
        }
        let url = element.attr('data-url');

        $.ajax({
            type: 'patch',
            url: url,
            dataType: 'json',
            error: function (data) {

            },
            success: function (data) {
                let tpl = $(data.template);
                tpl.insertBefore(element.parent());
                window.initInputs(tpl);
                window.initQuizQcm(tpl);
                tpl.find('select').each(function () {
                    window.initLanguageInput('#' + $(this).attr('id'));
                });
            }
        });
    }

    window.initInputs = function (parent) {


        parent.find('[data-type=quiz-qcm]').each(function () {
            window.initQuizQcm($(this));
        });

        parent.find('[data-type=quiz-video]').each(function () {
            window.initQuizVideo($(this));
        });

        parent.find('[data-type=quiz-accordion]').each(function () {
            window.initQuizAccordion($(this));
        });

        parent.find('[data-type=delete]').each(function () {
            $(this).click(window.deleteElement);
        });

        parent.find('[data-type=toggle-status]').each(function () {
            $(this).click(window.toggleStatus);
        });

        parent.find('select').each(function () {

            let data = $(this).data('type');
            let c = $(this).find('option').length;
            let min = c > 8. ? 2 : -1;

            if (data === "select2") {

                $(this).select2({minimumResultsForSearch: min});

            } else if (data === "select2-sm") {

                $(this).select2({
                    dropdownCssClass: "select2-sm",
                    selectionCssClass: "select2-sm",
                    minimumResultsForSearch: min
                });
            }

            $(this).on('select2:open', function () {
                $('.select2-selection__rendered').addClass('rotate-arrow');
            });

            $(this).on('select2:close', function () {
                $('.select2-selection__rendered').removeClass('rotate-arrow');
            });
        });

        parent.find('input[data-type=mask]').each(function () {
            $(this).inputmask();
        });

        parent.find('input[data-type=datepicker]').each(function () {
            $(this).datepicker({format: 'dd/mm/yyyy', autoclose: true});
        });

        parent.find('.collapse').on('show.bs.collapse', function () {
            window.toggleCollapseIcon($(this));
        });

        parent.find('.collapse').on('hide.bs.collapse', function () {
            window.toggleCollapseIcon($(this));
        });
        parent.find('.file-upload').each(function () {
            window.initFileUpload($(this));
        });


    }

    window.initFileUpload = function (element) {

        let id = element.attr('data-id');
        let uploadUrl = element.attr('data-upload-url');
        let acceptedFiles = element.attr('data-accepted-files');
        let deleteUrl = element.attr('data-url');
        let fileName = element.attr('data-filename');
        let fileSize = element.attr('data-filesize');

        let Container = $("#file-upload-container-" + id);
        let fileUploadContainer = Container.find('.file-upload');
        let fileUploadInput = fileUploadContainer.find('#' + id);
        let deleteInput = Container.find('input[name="delete[' + id + ']"');
        let progressContainer = Container.find('.file-progress');
        let progressBar = progressContainer.find('.progress-bar');
        let progressName = progressContainer.find('.progress-name');
        let cancelUploadBtn = progressContainer.find('.cancel-upload');

        let fileExistsContainer = Container.find('.file-exists');
        let fileExistsName = fileExistsContainer.find('.file-name');
        let fileExistsSize = fileExistsContainer.find('.file-size');
        let deleteFileBtn = fileExistsContainer.find('.delete-file');

        let uploadFile;
        let jqXHR;

        fileUploadInput.fileupload({

            add: function (e, data) {

                cancelUploadBtn.unbind();
                deleteFileBtn.unbind();

                data.url = uploadUrl;
                let valid = true;
                uploadFile = data.files[0];

                if (typeof acceptedFiles !== 'undefined') {

                    var regex = new RegExp("\\.(" + acceptedFiles + ")$", "i");
                    if (!regex.test(uploadFile.name)) {

                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            title: "{{ __('mauvais format d\'image')}}",
                            showConfirmButton: false,
                            timer: 1800
                        });

                        valid = false;
                    }

                }

                if (valid === true) {
                    jqXHR = data.submit();
                    cancelUploadBtn.bind('click', function (e) {
                        jqXHR.abort();
                        cancelUploadBtn.unbind();
                    });
                    fileUploadContainer.addClass('d-none');
                    progressName.html(uploadFile.name);
                    progressContainer.removeClass('d-none').addClass('d-flex');
                }
            },
            progress: function (e, data) {
                deleteInput.val('');
                let progress = parseInt(data.loaded / data.total * 100, 10);
                progressBar.css('width', progress + '%');
            },
            done: function (e, data) {
                progressContainer.addClass('d-none');
                fileExistsName.html(uploadFile.name);
                deleteFileBtn.bind('click', function (e) {
                    cancelUploadBtn.unbind();
                    deleteFileBtn.unbind();
                    fileUploadContainer.removeClass('d-none').addClass('d-flex');
                    fileExistsContainer.addClass('d-none').removeClass('d-flex');
                });
                fileExistsContainer.removeClass('d-none').addClass('d-flex');
            }
        });

        if (typeof fileName !== 'undefined') {
            progressContainer.addClass('d-none');
            fileUploadContainer.addClass('d-none').removeClass('d-flex');
            fileExistsContainer.removeClass('d-none').addClass('d-flex');

            {{--
            fileName = "<a class='' href='{{ route('preview-media') }}' target='_blank'>"+fileName+"</a>";
            --}}
            fileExistsName.html(fileName);
            fileExistsSize.html(fileSize + ' MB');
            deleteFileBtn.bind('click', function (e) {
                cancelUploadBtn.unbind();
                deleteFileBtn.unbind();
                deleteInput.val(true);
                fileUploadContainer.removeClass('d-none').addClass('d-flex');
                fileExistsContainer.addClass('d-none').removeClass('d-flex');
                if (typeof deleteUrl !== 'undefined') {
                    $.ajax({
                        type: 'patch',
                        url: deleteUrl
                    });
                }
            });

            fileExistsContainer.removeClass('d-none').addClass('d-flex');
        }

    };

    window.deleteElement = function (event) {

        let element = $(event.target);
        if (element.prop('nodeName').toLowerCase() !== 'a' && element.prop('nodeName').toLowerCase() !== 'button') {
            element = element.parent('a,button');
        }

        let url = element.attr('data-url');
        let title = element.attr('data-title');
        let method = element.attr('data-method');
        if (!url) {
            return false;
        }

        if (!method) {
            method = "delete";
        }

        Swal.fire({
            position: 'center',
            icon: 'warning',
            iconHtml: '<i class="fal fa-trash-alt small"></i> ',
            title: title,
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler',
            customClass: {
                confirmButton: 'btn btn-primary text-white me-2 my-3',
                cancelButton: 'btn btn-muted ms-2 my-3'
            },
            buttonsStyling: false,
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: method,
                    url: url,
                    dataType: 'json',
                    error: function (data) {

                    },
                    success: function (data) {
                        if (typeof data.redirect !== 'undefined') {
                            window.location.href = data.redirect;
                        } else  {
                            window.location.reload();
                        }
                    }
                });
            }
        });

    };

    window.toggleStatus = function (event) {

        let element = $(event.target);
        if (element.prop('nodeName').toLowerCase() !== 'a' && element.prop('nodeName').toLowerCase() !== 'button') {
            element = element.parent('a,button');
        }

        let url = element.attr('data-url');
        let title = element.attr('data-title');
        let method = element.attr('data-method');
        if (!url) {
            return false;
        }

        if (!method) {
            method = "patch";
        }

        Swal.fire({
            position: 'center',
            icon: 'success',
            iconHtml: '<i class="fal fa-wave-pulse small"></i> ',
            title: title,
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler',
            customClass: {
                confirmButton: 'btn btn-primary text-white me-2 my-3',
                cancelButton: 'btn btn-muted ms-2 my-3'
            },
            buttonsStyling: false,
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: method,
                    url: url,
                    dataType: 'json',
                    error: function (data) {

                    },
                    success: function (data) {
                        if (typeof data.redirect !== 'undefined') {
                            window.location.href = data.redirect;
                        } else  {
                            window.location.reload();
                        }
                    }
                });
            }
        });

    };

    window.toggleCollapseIcon = function (collapseElement) {

        let element = collapseElement.parents('.card').find('[data-bs-toggle=collapse]')
        if (element.length > 0) {
            if (element.prop('nodeName').toLowerCase() !== 'a') {
                element = element.parent('a');
            }

            let icon = element.first('i');
            if (icon.hasClass('fa-chevron-down')) {
                icon.removeClass('fa-chevron-down');
                icon.addClass('fa-chevron-up');
            } else if (icon.hasClass('fa-chevron-up')) {
                icon.removeClass('fa-chevron-up');
                icon.addClass('fa-chevron-down');
            }
        }

    }
    //$(document).ready(function () {
    document.addEventListener("DOMContentLoaded", function (event) {

        initInputs($('body'));

        @if(Session::has('success'))

        Swal.fire({
            position: 'bottom-end',
            icon: 'success',
            title: "{{ Session::get('success') }}",
            showConfirmButton: false,
            timer: 1800
        });

        @endif

        @if(Session::has('error'))

        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "<h5>{{ Session::get('error') }}</h5>",
            showConfirmButton: false,
            timer: 1800
        });

        @endif
    });
</script>
@stack('scripts')

</body>
</html>

