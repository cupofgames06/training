<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
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
            $this->address_city(),
            view('components.datatable.action._body', ['route' => route('of.trainers.edit', ['trainer'=>$this->id])])->render()
        ];
    }
}
