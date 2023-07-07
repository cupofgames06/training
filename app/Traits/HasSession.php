<?php

namespace App\Traits;

use App\Models\Session;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasSession {

    public function sessions(): HasMany
    {
        return $this->HasMany(Session::class);
    }

    public function ordered_sessions()
    {
        $r = $this->sessions->sortBy(function ($session) {
            return $session->date_start;
        });

        return $r;
    }
}
