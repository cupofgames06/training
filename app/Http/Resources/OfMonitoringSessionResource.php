<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class OfMonitoringSessionResource extends JsonResource
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
            !empty($this->date_start)?$this->first_day->calendar_date:'-',
            $this->course->description->reference,
            $this->course->description->name,
            isset($this->classroom->address)?$this->classroom->address_city():null,
            $this->status,
            $this->enrollments->count()."/". $this->classroom->max_learners,
            '100€',
            view('components.datatable.action._body', ['route' => route('of.monitoring.sessions.details', [$this])])->render()
        ];
    }
}
