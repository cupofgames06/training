<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
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
            $this->name,
            $this->address_postal_code(),
            $this->address_city(),
            $this->max_learners,
            view('components.datatable.action._body', ['route' => route('of.classrooms.edit', ['locale'=>app()->getLocale(),'classroom'=>$this->id])])->render()
        ];
    }
}
