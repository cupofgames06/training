<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['switchAccount', 'logout']);
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->setAccount();
        return $this->redirectTo();
    }

    public function switchAccount($locale, $role, $id)
    {
        $check = false;
        $accounts = Auth::user()->getAccounts();
        foreach ($accounts as $acc) {
            if ($acc->id == $id && $acc->route == $role) {
                $check = true;
            }
        }

        if(!$check){
            abort('403');
        }
        Auth::user()->setAccount($role, $id);

        return $this->redirectTo();
    }

    protected function redirectTo()
    {
        return redirect(route(Cache::get('account')->route . '.index'));
    }
}
