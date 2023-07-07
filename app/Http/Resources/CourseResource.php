<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class CourseResource extends JsonResource
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
            custom('course-type')[$this->type]['name'],
            $this->time_duration,
            view('components.datatable.action._body', ['route' => route('of.courses.edit', [$this])])->render()
        ];
    }
}
