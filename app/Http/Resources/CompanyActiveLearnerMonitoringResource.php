<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Tags\Tag;

class CompanyActiveLearnerMonitoringResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            $this->profile->full_name,
            $this->countTotal()['events'].' | '.$this->countTotal()['hours'],
            $this->countFinish()['events'].' | '.$this->countFinish()['hours'],
            $this->countInProgress()['events'].' | '.$this->countInProgress()['hours'],
            $this->countNext()['events'].' | '.$this->countNext()['hours'],
            view('components.datatable.action._body', ['route' => route('company.monitoring.details', ['locale'=>app()->getLocale(),'learner'=>$this->id,'type'=>'active'])])->render()
        ];
    }
}
