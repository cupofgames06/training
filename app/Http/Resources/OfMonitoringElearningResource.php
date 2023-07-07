<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class OfMonitoringElearningResource extends JsonResource
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
            date( custom('date_format').' H:i', strtotime($this->created_at)),
            "-",
            $this->enrollmentable->description->reference,
            $this->company->entity->name,
            $this->user->profile->full_name,
            $this->status,
            '-',
            '-',
            view('components.datatable.action._body', ['route' => route('of.monitoring.elearning.details', [$this])])->render()
        ];
    }
}
