<?php

namespace App\Http\Resources;

use App\Models\Company;
use Carbon\CarbonInterval;
use Illuminate\Http\Resources\Json\JsonResource;

class OfMonitoringCustomerLearnerResource extends JsonResource
{
    public static Company $company;

    public static function company($value){
        self::$company = $value;
    }

    public function toArray($request): array
    {
        return [
            $this->profile->full_name,
            $this->countTotal()['events'].' | '.$this->countTotal()['hours'],
            $this->countFinish()['events'].' | '.$this->countFinish()['hours'],
            $this->countInProgress()['events'].' | '.$this->countInProgress()['hours'],
            $this->countNext()['events'].' | '.$this->countNext()['hours'],
            view('components.datatable.action._body', ['route' => route('of.monitoring.customer.leaner.details', ['locale'=>app()->getLocale(),'company'=>self::$company,'learner'=>$this,'type'=>'active'])])->render()
        ];
    }
}
