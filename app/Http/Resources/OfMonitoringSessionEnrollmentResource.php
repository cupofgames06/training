<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class OfMonitoringSessionEnrollmentResource extends JsonResource
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
            $this->user->profile->full_name,
            $this->company->entity->name,
            $this->created_at,
            true,
            'NA',
            '-',
            '-',
            '-'
        ];
    }
}
