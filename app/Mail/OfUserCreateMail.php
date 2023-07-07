<?php

namespace App\Mail;

use Illuminate\Support\Facades\Password;

class OfUserCreateMail extends BaseMailable
{

    public function __construct($view, $data = [])
    {

        //données essentielles
        if (empty($data['user']) || empty($data['of'])) {
            abort(404);
        }

        $token = Password::broker()->createToken($data['user']);

        // Generate the reset password URL
        $data['url'] = url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $data['user']->getEmailForPasswordReset()], false));

        $this->view = $view;
        $this->subject = trans('mail.' . $view . '.subject', ['name' => $data['of']->entity->name]);

        parent::__construct($data);
    }
}
