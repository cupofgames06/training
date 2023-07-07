<?php

namespace App\Http\Controllers;

use App\Mail\OfUserCreateMail;
use App\Models\Of;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{

    public function mail(): void
    {

        $message = (new OfUserCreateMail('user.create', [
            'of' => Of::find(1),
            'user' => User::find(1),
        ]))->onQueue('emails');

        echo $message->render();

        $to = 'jb@milleniumprod.com';

        try {
            Mail::to($to)->locale('fr')->queue($message);
        } catch (\Exception $error) {
            dd($error);
        }
    }

}
