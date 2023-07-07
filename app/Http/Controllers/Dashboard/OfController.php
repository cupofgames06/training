<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Of\Traits\HasHelp;
use App\Models\Of;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class OfController extends Controller
{
    use hasHelp;

    public mixed $of = null;

    public function __construct()
    {
        if (Cache::has('account')) {
            $this->of = Of::find(Cache::get('account')->id);
            View::share('of', $this->of);
        }
        parent::__construct();
    }
}
