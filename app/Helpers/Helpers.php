<?php

use Carbon\Carbon;

if (!function_exists('fake_translation')) {
    function fake_translation($property = 'name'): array
    {
        $fakerLocales = config('app.supported_faker_locales');

        return collect(config('app.supported_locales'))
            ->mapWithKeys(fn($locale, $key) => [$locale => fake($fakerLocales[$key])->unique()->$property])
            ->toArray();
    }
}

if (!function_exists('url_translation')) {
    function url_translation($property = 'name'): string
    {
        foreach (request()->segments() as $key => $segment) {
            if (!is_numeric($segment) && !in_array($segment, ['create', 'edit', 'dashboard'])) {

                $prefix[] = $segment;
            }
        }
        $prefix[] = $property;

        return implode('.', $prefix);
    }
}
if (!function_exists('rgb')) {
    function rgb($color): string
    {
        return implode(', ', sscanf($color, "#%02x%02x%02x"));
    }
}

if (!function_exists('get_domain')) {
    function get_domain()
    {
        $host = request()->getHttpHost();
        $domains = config('domains');
        $key = 'default';
        foreach ($domains as $k => $d) {
            $key = array_search($host, $d);
            if ($key !== false) {
                return $k;
            }
        }

        return $key;
    }
}

if (!function_exists('custom')) {
    function custom($key)
    {
        return config('custom.' . get_domain() . '.' . $key);
    }
}
if (!function_exists('courses_tab')) {
    function courses_tab($selected = ''): array
    {

//todo : méthode générales qui excluent les deleted, à reporter sur les listes et les listesselect
        $courses = \App\Models\Course::where('status','!=','deleted')->count();
        $packs = \App\Models\Pack::where('type', 'pack')->where('status','!=','deleted')->count();
        $blendeds = \App\Models\Pack::where('type', 'blended')->where('status','!=','deleted')->count();
        $tab_nav = [
            (object)['id' => 'courses-tab', 'title' => 'Formations','count'=> $courses , 'route' => route('of.courses.index'), 'selected' => $selected == 'courses'],
            (object)['id' => 'packs-tab', 'title' => 'Packs e-learning','count'=> $packs , 'route' => route('of.packs.index'), 'selected' => $selected == 'packs'],
            (object)['id' => 'blended-tab', 'title' => 'Parcours','count'=> $blendeds , 'route' => route('of.blendeds.index'), 'selected' => $selected == 'blendeds']
        ];

        return $tab_nav;
    }
}
if(!function_exists('convertSecondsToHoursMinutes')){
    function convertSecondsToHoursMinutes($value): string
    {
        $dt = Carbon::now();
        $hours = $dt->diffInHours($dt->copy()->addSeconds($value));
        $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($value)->subHours($hours));
        if($minutes == 0)
        {
            return $hours.'h';
        }
        if($minutes < 10)
        {
            return $hours.'h0'.$minutes;
        }
        return $hours.'h'.$minutes;
    }
}
