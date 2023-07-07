<?php

namespace App\Traits;

use App\Models\OfferDescription;
use App\Models\Price;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use ReflectionClass;

trait IsOffer
{

    public function description() :MorphOne
    {
        return $this->morphOne(OfferDescription::class, 'describable');
    }

    public function scopeViewable(): mixed
    {
        //todo : doir retourner un 409 , ... exception, ...
        //todo : vérif : intra, status, full (max learners), date passed
        return true;
    }

    public function getUrlAttribute(): mixed
    {
        return route('front.offers.course', ['course_id' => $this->course_id, 'session_id' => $this->id]);
    }

    public function getEditorUrlAttribute(): mixed
    {
        $route = $this->route_name;
        return route('of.' . $route . 's.edit', [$route => $this->id]);
    }

    public function getPreviewUrlAttribute(): mixed
    {
        return route('front.offers.' . $this->route_name, [$this->id, 'preview' => true]);
    }

    public function monitoringUrl($learner,$company,$type = 'active') : mixed
    {

        return route(Cache::get('account')->route.'.monitoring.' . $this->route_name, [$this->id,'monitoring' => true,'learner'=>$learner->id,'company'=>$company->id,'type' =>$type]);
    }
    public function getRouteNameAttribute(): mixed
    {
        $reflection = new ReflectionClass(self::class);
        $route = strtolower($reflection->getShortName());

        return $route;
    }

    public function getLeftSeats(): int
    {
        //todo
        return 5;
    }


    public function storeImage()
    {
        //Vérif upload, suppression tmp le cas échéant
        $tmp = Auth::user()->getMedia('tmp')->where('name', 'offer_image')->first();
        if (!empty($tmp)) {
            $reflection = new ReflectionClass($this::class);
            $type = strtolower($reflection->getShortName());
            $this->description->copyMedia($tmp->getPath())->usingName($type.'_' . $this->id.'_offer_image')->withResponsiveImages()->toMediaCollection('image');
        }

        Auth::user()->clearMediaCollection('tmp');
    }

    /**
     * @throws \ReflectionException
     */
    public function updateImage(){

        $tmp = Auth::user()->getMedia('tmp')->where('name', 'offer_image')->first();
        if (!empty($tmp)) {
            $reflection = new ReflectionClass($this::class);
            $type = strtolower($reflection->getShortName());
            $this->description->clearMediaCollection('image');
            $this->description->copyMedia($tmp->getPath())->usingName($type.'_' . $this->id.'_offer_image')->withResponsiveImages()->toMediaCollection('image');
        }

        Auth::user()->clearMediaCollection('tmp');
    }

}
