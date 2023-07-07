<?php

namespace App\Http\Controllers\Dashboard\Of\Traits;

use Illuminate\Support\Facades\Route;

trait HasHelp
{
    public function help()
    {
        $type = request()->segments()[2];
        return view('dashboard.pages.help',[' type'=>$type]);
    }

}
