<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\Session;
use Carbon\Carbon;

trait CountEnrollment {

    public function countTotal(?Carbon $from = null, ?Carbon $to = null)
    {
        $enrollments = $this->enrollments()->whereNotIn('status',['deleted','cancelled'])->when($from && $to, function ($query) use ($from, $to) {
            $query->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        })->get();
        $ret = array(
            'events' => $enrollments->count(),
            'secondes' => 0,
        );
        foreach ($enrollments as $enrollment)
        {
            if($enrollment->enrollmentable instanceof Session)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration;
            }
            if($enrollment->enrollmentable instanceof Course)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration * 60; // la duration est save en minutes en db
            }
        }

        $ret['hours'] = convertSecondsToHoursMinutes($ret['secondes']);

        return $ret;
    }
    public function countNext(?Carbon $from = null, ?Carbon $to = null)
    {
        $enrollments = $this->enrollments()->whereNotIn('status',['deleted','cancelled'])->when($from && $to, function ($query) use ($from, $to) {
            $query->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        })
        ->where(function($query){
            $query->whereHasMorph('enrollmentable',[Session::class],function ($query) {
                $query->whereIn('id', function ($query) {
                    $query->select('session_id')
                        ->from('session_days')
                        ->where('date', '>', Carbon::today());
                });
            });
        })->get();
        $ret = array(
            'events' => $enrollments->count(),
            'secondes' => 0,
        );
        foreach ($enrollments as $enrollment)
        {
            if($enrollment->enrollmentable instanceof Session)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration;
            }
            if($enrollment->enrollmentable instanceof Course)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration * 60; // la duration est save en minutes en db
            }
        }

        $ret['hours'] = convertSecondsToHoursMinutes($ret['secondes']);

        return $ret;
    }
    public function countInProgress(?Carbon $from = null, ?Carbon $to = null)
    {
        $enrollments = $this->enrollments()
            ->whereNotIn('status',['deleted','cancelled'])
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            })->where(function($query){
                $query->whereHasMorph('enrollmentable',[Session::class],function ($query) {
                    $query->whereIn('id', function ($query) {
                        $query->select('session_id')
                            ->from('session_days')
                            ->where('date', '=', Carbon::today());
                    });
                });
            })->get();
        $ret = array(
            'events' => $enrollments->count(),
            'secondes' => 0,
        );
        foreach ($enrollments as $enrollment)
        {
            if($enrollment->enrollmentable instanceof Session)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration;
            }
            if($enrollment->enrollmentable instanceof Course)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration * 60; // la duration est save en minutes en db
            }
        }

        $ret['hours'] = convertSecondsToHoursMinutes($ret['secondes']);

        return $ret;
    }
    public function countFinish(?Carbon $from = null, ?Carbon $to = null)
    {

        $enrollments = $this->enrollments()
            ->whereNotIn('status',['deleted','cancelled'])
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            })
            ->where(function($query){
                $query->whereHasMorph('enrollmentable',[Session::class],function ($query) {
                    $query->whereIn('id', function ($query) {
                        $query->select('session_id')
                            ->from('session_days')
                            ->where('date', '<', Carbon::today());
                    });
                });
            })->get();

        $ret = array(
            'events' => $enrollments->count(),
            'secondes' => 0,
        );
        foreach ($enrollments as $enrollment)
        {
            if($enrollment->enrollmentable instanceof Session)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration;
            }
            if($enrollment->enrollmentable instanceof Course)
            {
                $ret['secondes'] += $enrollment->enrollmentable->duration * 60; // la duration est save en minutes en db
            }
        }

        $ret['hours'] = convertSecondsToHoursMinutes($ret['secondes']);

        return $ret;
    }

}
