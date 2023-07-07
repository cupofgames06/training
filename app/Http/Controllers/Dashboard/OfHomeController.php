<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Of;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class OfHomeController extends OfController
{


    public function index()
    {

        return view('dashboard.pages.index', ['of' => $this->of]);
    }
}
