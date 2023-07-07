<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class OfMonitoringCustomerResource extends JsonResource
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
            $this->entity->name,
            $this->address_postal_code(),
            $this->address_city(),
            view('components.datatable.action._body', ['route' => route('of.monitoring.customer.details', [$this])])->render()
        ];
    }
}
