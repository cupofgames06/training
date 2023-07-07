<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Of\Traits\HasHelp;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class TrainerController extends Controller
{
    use hasHelp;

    public mixed $trainer = null;

    public function __construct()
    {
        if (Cache::has('account')) {
            $this->trainer = Trainer::find(Cache::get('account')->id);
            View::share('trainer', $this->trainer);
        }
        parent::__construct();
    }

    public function index(Request $request)
    {
        return redirect()->to(route('trainer.sessions.index'))->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}
