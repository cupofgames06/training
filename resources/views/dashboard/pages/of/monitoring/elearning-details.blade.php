<x-auth-layout>

        <x-content.breadcrumb :breadcrumbs="[route('of.monitoring.elearnings')=>trans('of.monitoring.elearnings.title'),'#'=>trans('of.monitoring.elearning.edit.title')]"></x-content.breadcrumb>
        <x-content.header title="{{ $enrollment->enrollmentable->description->reference }}" :subTitle="$enrollment->enrollmentable->description->name"></x-content.header>

        <div class="card">
            <div class="card-header">
                Evaluation par {{ $enrollment->user->profile->full_name }}
            </div>
            <div class="card-body"></div>
        </div>

</x-auth-layout>
