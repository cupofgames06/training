<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $amount = $this->amount;
        $amount .= $this->percent == true?'%':'€';
        return [
            $this->name,
            $amount,
            view('components.datatable.action._body', ['route' => route('of.promotions.edit', ['locale'=>app()->getLocale(),'promotion'=>$this->id])])->render()
        ];
    }
}
