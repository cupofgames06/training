<?php

namespace App\Http\Resources;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OfMonitoringCustomerLearnerLeftResource extends JsonResource
{
    public static Company $company;

    public static function company($value){
        self::$company = $value;
    }

    public function toArray($request): array
    {

        return [
            $this->profile->full_name,
            Carbon::parse($this->history->date_end)->format(custom('date_format')),
            view('components.datatable.action._body', ['route' => route('of.monitoring.customer.leaner.details', ['locale'=>app()->getLocale(),'company'=>self::$company,'learner'=>$this,'type'=>'left'])])->render()
        ];
    }
}
