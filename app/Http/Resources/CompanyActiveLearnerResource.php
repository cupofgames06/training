<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Tags\Tag;

class CompanyActiveLearnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return = [
            $this->profile->full_name,
            Carbon::parse($this->description->date_start)->format(custom('date_format'))
        ];

        foreach (custom('tags.learner') as $k => $v) {
            $return[] = $this->description->tags()->where('type',$k)->first() != null ? $this->description->tags()->where('type',$k)->first()->name : '';
        }

        $return[] = view('components.datatable.action._body',
            ['route' => route('company.learners.edit', ['locale' => $request->getLocale(), 'learner' => $this->id])])->render();

        return $return;
    }
}
