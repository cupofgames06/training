<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="[route('of.courses.index')=>trans('of.courses.index.title'),'#'=>trans('of.courses.edit.title')]"></x-content.breadcrumb>
        <x-content.header title="{{ $course->description->reference }}"
                          :subTitle="$course->description->name"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <x-form :action="route('of.courses.elearning_selected',['course'=>$course])" id="course_edit_form"
                v-on:submit="checkForm">
            @method('patch')
            @csrf

            <div class="row">
                <div class="col-md-12 col-lg-6 mb-4">

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="far fa-boxes-packing text-primary"></i>
                            Outil auteur
                        </div>

                        <div class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Nullam eget ligula id justo aliquet ornare sed ut erat. Praesent bibendum nibh augue, et
                            efficitur nisi cursus at.
                        </div>
                        <div class="card-footer">
                            <x-form-submit id="quiz" ajax="1" form_id="elearning_selection">
                                Créer un quiz
                            </x-form-submit>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-4">

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="far fa-boxes-packing text-primary"></i>
                            {{ __('Module SCORM') }}
                        </div>

                        <div class="card-body">
                            Praesent bibendum nibh augue, et efficitur nisi cursus at.
                            <div class="my-4">
                                <div class="form-group">
                                    <x-form-label class="form-label"
                                                  label="téléchargement du module"></x-form-label>
                                    @component('components.form.file-upload')
                                        @slot('id','offer_image')
                                        @slot('url',  '' )
                                        @slot('text','Format : ZIP')
                                        @slot('accepted_files',['png','jpg','jpeg'])
                                        @slot('file', !empty($description)?$description->getFirstMedia('image'):null )
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <x-form-submit id="scorm" ajax="1" form_id="elearning_selection">
                                {{ __('Ajouter un module SCORM') }}
                            </x-form-submit>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>

</x-auth-layout>
