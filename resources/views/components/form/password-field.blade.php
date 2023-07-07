<div class="form-group">
    <label class="form-label w-100" for="password">
        {{ __('common.user.password') }}
    </label>
    <div class="input-group" id="show_hide_password">
        <input class="form-control" type="password" id="password" name="user[password]">
        <div class="input-group-text bg-white border-start-0">
            <a href="#" class=""><i class="fa fa-eye-slash text-dark" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<script type="module">
    $(document).ready(function () {

        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });
</script>
