<div class="row">
    <div class="col-md-12 col-lg-6">
        @include('dashboard.partials.profile',['profile'=>!empty($user)?$user->profile:null])
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card">

            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-lock text-primary"></i>
                {{ __('common.user_title') }}</div>
            <div class="card-body">
                <div class="row">
                    @if( empty($user) || $user->id != Auth::id())

                        <div class="col mb-3 pb-3">
                            <x-form.text-field label="{{ __('common.user.email') }}"
                                               name="user[email]"
                                               :value="!empty($user)?$user->email:''">
                            </x-form.text-field>
                        </div>

                    @else

                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                            <x-form.text-field label="{{ __('common.user.email') }}"
                                               name="user[email]" :value="!empty($user)?$user->email:''">
                            </x-form.text-field>
                        </div>

                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                            @component('components.form.password-field')
                            @endcomponent
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
