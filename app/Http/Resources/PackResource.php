<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackResource extends JsonResource
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
            $this->description->reference??'-',
            $this->description->name??'-',
            view('components.datatable.action._body', ['route' => route('of.'.$this->type.'s.edit', [$this])])->render()
        ];
    }
}
