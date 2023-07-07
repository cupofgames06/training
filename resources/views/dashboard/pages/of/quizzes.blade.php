<x-auth-layout>
    <div class="quiz-editor">
        <x-content.breadcrumb :breadcrumbs="$breadcrumbs"></x-content.breadcrumb>
        <x-content.header title="{{ $title }}" :subTitle="$subtitle"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-xl-3 col-md-12">

                <div class="card mb-4 quiz-editor-add-module-container">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div style="width:68%">
                            <x-form-select
                                id="changeVersion"
                                name="changeVersion"
                                :default="$version->getEditorUrl()"
                                :options="$quiz->getEditorVersionList()"
                                class="form-control"
                                data-type="select2"
                            />
                        </div>
                        <div>
                            <button class="btn btn-primary px-3"
                                    href="#" id="addVersion"><i class="fal fa-plus-circle"></i>
                            </button>

                            <button class="btn btn-primary px-3"
                                    href="#" id="copyVersion"><i class="fal fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="quiz-editor-add-module" id="quiz-editor-add-module">

                            @foreach(config('quiz.module.type.content') as $k => $v)
                                <div class="quiz-editor-add-module-item pb-2" data-module-type="content"
                                     data-module-subtype="{{ $k }}">
                                    <div class="btn btn-lg rounded-circle p-2 btn-secondary"><i
                                            class="far fa-lg {{ $v['icon'] }}"></i></div>
                                    <div class="small text-muted pt-1">{{ $v['label'] }}</div>
                                </div>
                            @endforeach

                            <hr class="my-3 border-muted w-100">

                            @foreach(config('quiz.module.type.question') as $k => $v)
                                <div class="quiz-editor-add-module-item pb-2" data-module-type="question"
                                     data-module-subtype="{{ $k }}">
                                    <div class="btn btn-lg  p-2  rounded-circle btn-primary text-white"><i
                                            class="far fa-lg {{ $v['icon'] }}"></i>
                                    </div>
                                    <div class="small text-muted pt-1">{{ $v['label'] }}</div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-12 mb-3 pb-3">
                <div class="page-name card mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex justify-content-between">

                            <div class="page-title">
                                <x-form.translated-inline-field label="" name="page[name]" :id="'page-name-'.$page->id"
                                                                :values="$page->getTranslations('name')">
                                </x-form.translated-inline-field>
                            </div>

                            <div class="page-options">

                                <x-form-select
                                    id="changePage"
                                    name="changePage"
                                    :default="$page->getEditorUrl()"
                                    :options="$version->getEditorPageList()"
                                    class="form-control"
                                    data-type="select2"
                                />

                                <span class="ms-2 d-none d-md-inline"></span>

                                <x-form-select
                                    id="pageMinScore"
                                    name="page[min_score]"
                                    placeholder="Min. score"
                                    :default="$page->min_score"
                                    :options="[ 0=>'0%',25 => '25%',50 => '50%',75 => '75%',100 => '100%']"
                                    class="form-control"
                                    data-type="select2"
                                />

                                <div>
                                    <button class="btn btn-primary ms-2" id="addPage" data-type="add"><i
                                            class="far fa-plus-circle"></i>
                                        <span
                                            class="d-none d-md-inline">
                                        Page
                                        </span>
                                    </button>

                                    <a href="#" type="button" id="togglePage" data-page-open="1"
                                       class="pe-2 ps-2 fas fa-chevron-up text-decoration-none">
                                    </a>

                                    @if($version->pages->count() == 1)
                                        <a href="#"
                                           class="fas fa-close text-muted text-decoration-none opacity-25">
                                        </a>
                                    @else
                                        <a href="#"
                                           data-type="delete"
                                           data-title="Supprimer cette page et son contenu?"
                                           data-url="{{ route('of.quizzes.delete_page',[$page->id]) }}"
                                           class="fas fa-close text-decoration-none" id="deletePage">
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div id="page" class="page  w-100 min-vh-100">
                    <div id="page-content">
                        @foreach($page->modules->sortBy('position') as $module)
                            <x-form.quiz.base-module :module="$module"></x-form.quiz.base-module>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('sticky-footer')
        @component('components.content._sticky-footer')

            @slot('buttons')
                <a class="btn btn-outline-danger me-3"
                   data-url="{{ route('of.quizzes.delete_version',['version'=>$version]) }}"
                   data-title="Supprimer définitivement la version {{ $version->version }}?"
                   data-type="delete" href="#"><i class="fal fa-trash-alt"></i><span
                        class="d-none d-md-inline"> {{ __('of.quiz.delete_version') }}</span></a>
            @endslot

            <a class="btn btn-outline-secondary me-3"
               href="{{  /*$quiz->getPreviewPageUrl($page->id)*/ '#' }}"><i
                    class="far fa-eye"></i> <span
                    class="d-none d-md-inline">{{ __('common.preview') }}</span>
            </a>

            @if($version->online == 1)

                <button id=""
                        data-type="toggle-status"
                        data-title="Retirer la version {{ $version->version }} de la mise en ligne?"
                        data-url="{{ route('of.quizzes.toggle-version-status',[ 'version'=>$version, 'status'=>0]) }}"
                        class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                        class="d-none d-md-inline">Retirer de la mise en ligne</span></button>

            @else

                <button id=""
                        data-type="toggle-status"
                        data-title="Mettre en ligne la version {{ $version->version }}?"
                        data-url="{{ route('of.quizzes.toggle-version-status',[ 'version'=>$version, 'status'=>1]) }}"
                        class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                        class="d-none d-md-inline">Mettre en ligne</span></button>

            @endif

        @endcomponent
    @endpush

    @push('scripts')
        <script type="module">
            let pageContent = document.getElementById('page-content');
            let contentModules = document.getElementById('quiz-editor-add-module');
            let sortableModules = new Sortable(contentModules, {
                group: {
                    name: 'shared',
                    pull: 'clone', // To clone: set pull to 'clone'
                    put: false
                },
                animation: 150,
                sort: false,
                draggable: ".quiz-editor-add-module-item",
                onStart: function (evt) {
                    $(pageContent).find('.collapse.show').removeClass('show').addClass('show-later');
                },
                onEnd: function (evt) {
                    $(pageContent).find('.show-later').addClass('show').removeClass('show-later');
                }
            });
            let sortablePageContent = new Sortable(pageContent, {
                group: {
                    name: 'shared',
                    pull: false,
                },
                animation: 150,
                draggable: ".base-module",
                filter: ".row",  // Selectors that do not lead to dragging (String or Function)
                preventOnFilter: false, // Call `event.preventDefault()` when triggered `filter`
                // handle: ".card-header",  // Drag handle selector within list items
                ghostClass: "drop-module",  // Class name for the drop placeholder
                onAdd: function (evt) {
                    let dropItem = $(evt.item);
                    addModule(dropItem);
                },
                onStart: function (evt) {

                    let dropItem = $(evt.item);
                    console.log('num ' + dropItem.find('[data-type=tinyMce]').length);
                    $(pageContent).find('.collapse.show').removeClass('show').addClass('show-later');

                    dropItem.find('[data-type=tinyMce]').each(function () {
                        tinymce.get($(this).attr('id')).save();
                        //tinymce.get($(this).attr('id')).remove();
                        console.log('start ' + $(this).attr('id'));
                    });

                },
                onEnd: function (evt) {

                    let dropItem = $(evt.item);
                    $(pageContent).find('.show-later').addClass('show').removeClass('show-later');
                    //console.log('num end '+dropItem.find('[data-type=tinyMce]').length);

                    dropItem.find('[data-type=tinyMce]').each(function () {
                        window.initTinyMceModuleInput('#' + $(this).attr('id'));
                        // console.log('end '+$(this).attr('id'));
                    });

                    let scrollOffset = 0;
                    if (dropItem.offset()) {
                        if (!scrollOffset || dropItem.offset().top < scrollOffset - 70) {
                            scrollOffset = dropItem.offset().top - 70;
                        }
                        $([document.documentElement, document.body]).animate({
                            scrollTop: scrollOffset
                        }, 20);
                    }
                    updateModulePosition(dropItem);
                }
            });
            /*
            sortableModules.option("onMove", function (evt) {
                scrollIfNeeded(evt);
            });

            sortablePageContent.option("onMove", function (evt) {
                scrollIfNeeded(evt);
            });
*/
            document.addEventListener("DOMContentLoaded", function (event) {
                $('#changePage').on('change', changePage);
                $('#addPage').on('click', addPage);
                $('#togglePage').on('click', togglePage);
                $('#addVersion').on('click', addVersion);
                $('#copyVersion').on('click', copyVersion);
                $('#changeVersion').on('change', changeVersion);
            });

            function scrollIfNeeded(evt) {
                let clientY = evt.originalEvent.clientY;
                //console.log(clientY);
                //console.log(clientY - window.scrollY);
                //console.log(window.innerHeight - (clientY - window.scrollY));
                /*
                let threshold = 260;
                var scrollDirection = null;
                if (clientY - window.scrollY < threshold) {
                    // If the cursor is near the top of the window, scroll up.
                    scrollDirection = -1;
                } else if (window.innerHeight - (clientY - window.scrollY) < threshold) {
                    // If the cursor is near the bottom of the window, scroll down.
                    scrollDirection = 1;
                }

                if (scrollDirection !== null) {
                    console.log(clientY);
                }
                */

            }

            function addModule(dropItem) {

                let type = dropItem.attr('data-module-type');
                let subtype = dropItem.attr('data-module-subtype');

                $.ajax({
                    type: 'patch',
                    url: '{{ route('of.quizzes.store_module',['page_id']) }}',
                    data: {
                        page_id: {{ $page->id }},
                        position: $(dropItem).index(),
                        type: type,
                        subtype: subtype,
                    },
                    dataType: 'json',
                    success: function (data) {
                        let tpl = $(data.template);
                        tpl.insertBefore(dropItem);
                        dropItem.remove();

                        tpl.find('select').each(function () {
                            window.initLanguageInput('#' + $(this).attr('id'));
                        });

                        tpl.find('textarea').each(function () {
                            window.initTinyMceModuleInput('#' + $(this).attr('id'));
                        });

                        tpl.find('.card-header').find('.inline-field-static').on('click', window.toggleInlineFieldEditor);
                        tpl.find('.card-header').find('.inline-field-static').on('click', disableDrag);

                        window.initInputs(tpl);

                        //tpl.find('.card-header').find('input[type=text]').on('focus', disableDrag);
                        //tpl.find('.card-header').find('input[type=text]').on('blur', enableDrag);

                        let scrollOffset = 0;
                        if (tpl.offset()) {
                            if (!scrollOffset || tpl.offset().top < scrollOffset - 70) {
                                scrollOffset = tpl.offset().top - 70;
                            }
                        }

                        $([document.documentElement, document.body]).animate({
                            scrollTop: scrollOffset
                        }, 20);
                    }
                });

            }

            function updateModulePosition(dropItem) {

                let module_id = $(dropItem).attr('data-module');
                let position = [];
                $(pageContent).find('.base-module').each(
                    function () {
                        position.push({
                            id: $(this).attr('data-module'),
                            position: $(this).index()
                        });
                    });

                $.ajax({
                    type: 'post',
                    url: '{{ route('of.quizzes.update_modules_position') }}',
                    data: {
                        position: position,
                    },
                    dataType: 'json',
                    success: function (data) {

                    }
                });
            }

            function togglePage(event) {

                let btn = $(event.target);
                let open = btn.attr('data-page-open');
                if (open == 1) {

                    btn.addClass('fa-chevron-down');
                    btn.removeClass('fa-chevron-up');

                    $(event.target).attr('data-page-open', 0);

                    $('#page-content').find('.collapse.show').each(
                        function () {
                            return new bootstrap.Collapse($(this)).hide();
                        });

                } else {

                    btn.removeClass('fa-chevron-down');
                    btn.addClass('fa-chevron-up');

                    $(event.target).attr('data-page-open', 1);

                    $('#page-content').find('.collapse:not(.show)').each(
                        function () {
                            return new bootstrap.Collapse($(this)).show();
                        });
                }
            }

            function changePage(event) {
                window.location.href = $(event.target).val();
            }

            function changeVersion(event) {
                window.location.href = $(event.target).val();
            }

            function copyVersion(event) {

                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Version copiée',
                    showConfirmButton: false,
                    timer: 1800
                }).then(function (result) {
                    $.ajax({
                        type: 'patch',
                        url: "{{ route('of.quizzes.copy_version',[$version->id]) }}",
                        dataType: 'json',
                        error: function (data) {

                        },
                        success: function (data) {
                            window.location.href = data.redirect;
                        }
                    });
                });


            }

            function addPage(event) {

                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Page ajoutée',
                    showConfirmButton: false,
                    timer: 1800
                }).then(function (result) {
                    $.ajax({
                        type: 'patch',
                        url: "{{ route('of.quizzes.store_page',[$version->id]) }}",
                        dataType: 'json',
                        error: function (data) {

                        },
                        success: function (data) {
                            window.location.href = data.redirect;
                        }
                    });
                });
            }

            function addVersion(event) {

                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Version ajoutée',
                    showConfirmButton: false,
                    timer: 1800
                }).then(function (result) {
                    $.ajax({
                        type: 'patch',
                        url: "{{ route('of.quizzes.store_version',[$quiz->id]) }}",
                        dataType: 'json',
                        error: function (data) {

                        },
                        success: function (data) {
                            window.location.href = data.redirect;
                        }
                    });
                });
            }

            function disableDrag(event) {
                sortablePageContent.option("disabled", true);
            }

            function enableDrag(event) {
                sortablePageContent.option("disabled", false);
            }

        </script>
    @endpush
</x-auth-layout>
